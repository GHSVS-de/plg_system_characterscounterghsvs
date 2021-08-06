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
		this.charsTypedLabel = Joomla.JText._(options.charsTypedLabel);
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
			console.log('remove maxlength');
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
		}

    };

    return VCountdown;
}));
