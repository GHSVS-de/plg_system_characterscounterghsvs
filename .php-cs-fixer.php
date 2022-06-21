<?php
$mainFinder = PhpCsFixer\Finder::create()
	//->exclude('node_modules')
	//->exclude('build')
	//->exclude('dist')
	->in(
		[
			__DIR__ . '/src',
		]
	);

$config = new PhpCsFixer\Config();

$phpCsFixerRules = require_once '../php-cs-fixer-ghsvs/.php-cs-fixer.rules.php';

$config
	->setRiskyAllowed(true)
	->setIndent("\t")
	->setRules($phpCsFixerRules)
	->setFinder($mainFinder);

return $config;
