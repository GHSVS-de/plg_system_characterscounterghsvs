/*!
Based upon: VCountdown 0.0.3 | (c) 2016 Pedro Rogério | MIT License.
Edited by ghsvs.de 2018.
*/

/*jslint browser: true*/
/*global define, module, exports*/
(function (root, factory)
{
	"use strict";

	if (typeof define === 'function' && define.amd)
	{
		define([], factory);
	}
	else if (typeof exports === 'object')
	{
		module.exports = factory();
	}
	else
	{
		root.VCountdown = factory();
	}
}(this, function ()
{
	"use strict";

	var VCountdown = function (options)
	{
		if (!this || !(this instanceof VCountdown))
		{
			return new VCountdown(options);
		}

		if (!options)
		{
			options = {};
		}

		if (!options.target)
		{
			throw 'Provide a target to count characters';
		}

		var matches = document.querySelectorAll(options.target);

		if (!matches || !matches.length)
		{
			return;
		}

		options.target = matches[0];
		this.target   = options.target;
		this.maxChars = options.maxChars || 140;
		this.chopText = options.chopText || false;
		this.removeMaxlength = options.removeMaxlength || false;
		this.charsTypedLabel = this.sanitizeHtml(
			Joomla.JText._(options.charsTypedLabel));
		this.countdown();
	};

	VCountdown.prototype =
	{
		hasClass: function (el, name)
		{
			return new RegExp('(\\s|^)' + name + '(\\s|$)').test(el.className);
		},

		addClass: function (el, name)
		{
			if (!this.hasClass(el, name))
			{
				el.className += (el.className ? ' ' : '') + name;
			}
		},

		removeClass: function (el, name)
		{
			if (this.hasClass(el, name))
			{
				el.className = el.className.replace(new RegExp('(\\s|^)' + name + '(\\s|$)'), ' ').replace(/^\s+|\s+$/g, '');
			}
		},

		createEls: function (name, props)
		{
			var el = document.createElement(name), p;

			for (p in props)
			{
				if (props.hasOwnProperty(p))
				{
					el[p] = props[p];
				}
			}
			return el;
		},

		insertAfter: function (referenceNode, newNode)
		{
			referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
		},

		update: function ()
		{
			var target = this.target,
			currentCount = target.value.length,
			remaining    = this.maxChars - currentCount;

			if (remaining > 10)
			{
				this.removeClass(target.nextElementSibling, 'warn');
				this.removeClass(target.nextElementSibling, 'overflow');
			}
			else if(remaining < 0)
			{
				this.addClass(target.nextElementSibling, 'overflow');
			}
			else
			{
				this.removeClass(target.nextElementSibling, 'overflow');
				this.addClass(target.nextElementSibling, 'warn');
			}

			var display = this.charsTypedLabel
				.replace('{currentCount}', `<span class=chars-typed>${currentCount}</span>`)
				.replace('{maxChars}', `<span class=chars-max>${this.maxChars}</span>`)
				.replace('{remaining}', `<span class=chars-remain>${remaining}</span>`);

			target.nextElementSibling.innerHTML = display;
		},

		deleteMaxlength: function ()
		{
			// console.log('remove maxlength');
			this.target.removeAttribute('maxlength');
		},

		setMaxChars: function ()
		{
			this.target.setAttribute('maxlength', this.maxChars);
		},

		charsLen: function ()
		{
			var span = this.createEls('span', {className: 'chars-length'});
			span.innerHTML = this.maxChars;
			this.insertAfter(this.target, span);
			this.update();
		},

		countdown: function ()
		{
			if (this.removeMaxlength)
			{
				this.deleteMaxlength();
			}

			if (this.chopText)
			{
				this.setMaxChars();
			}

			this.charsLen();
			this.target.addEventListener('keyup', this.update.bind(this), false);
		},

		/**
		* @copyright  (C) 2018 Open Source Matters, Inc. <https://www.joomla.org>
		* @license    GNU General Public License version 2 or later; see LICENSE.txt
		* @note: Changed/edited by ghsvs.de 2021. Adapted from Joomla 4 core.js.
		*/
		sanitizeHtml: function (unsafeHtml, sanitizeFn)
		{
			const ARIA_ATTRIBUTE_PATTERN = /^aria-[\w-]*$/i;
			const DATA_ATTRIBUTE_PATTERN = /^data-[\w-]*$/i;
			const allowList = {
				'*': ['class', 'dir', 'id', 'lang', 'role', ARIA_ATTRIBUTE_PATTERN, DATA_ATTRIBUTE_PATTERN],
				a: ['target', 'href', 'title', 'rel'],
				area: [],
				b: [],
				br: [],
				col: [],
				code: [],
				div: [],
				em: [],
				hr: [],
				h1: [],
				h2: [],
				h3: [],
				h4: [],
				h5: [],
				h6: [],
				i: [],
				img: ['src', 'srcset', 'alt', 'title', 'width', 'height'],
				li: [],
				ol: [],
				p: [],
				pre: [],
				s: [],
				small: [],
				span: [],
				sub: [],
				sup: [],
				strong: [],
				u: [],
				ul: [],
				button: ['type'],
				input: ['accept', 'alt', 'autocomplete', 'autofocus', 'capture', 'checked', 'dirname', 'disabled', 'height', 'list', 'max', 'maxlength', 'min', 'minlength', 'multiple', 'type', 'name', 'pattern', 'placeholder', 'readonly', 'required', 'size', 'src', 'step', 'value', 'width', 'inputmode'],
				select: ['name'],
				textarea: ['name'],
				option: ['value', 'selected']
			};

			if (!unsafeHtml.length)
			{
				return unsafeHtml;
			}

			if (sanitizeFn && typeof sanitizeFn === 'function')
			{
				return sanitizeFn(unsafeHtml);
			}

			const domParser = new window.DOMParser();
			const createdDocument = domParser.parseFromString(unsafeHtml, 'text/html');
			const allowlistKeys = Object.keys(allowList);
			const elements = [].concat(...createdDocument.body.querySelectorAll('*'));

			for (let i = 0, len = elements.length; i < len; i++)
			{
				const el = elements[i];
				const elName = el.nodeName.toLowerCase();

				if (!allowlistKeys.includes(elName)) {
					el.remove();
					continue;
				}

				const attributeList = [].concat(...el.attributes);
				const allowedAttributes = [].concat(allowList['*'] || [], allowList[elName] || []);
				attributeList.forEach(attr => {
					if (!allowedAttribute(attr, allowedAttributes)) {
						el.removeAttribute(attr.nodeName);
					}
				});
			}

			return createdDocument.body.innerHTML;
		}


    };

    return VCountdown;
}));
