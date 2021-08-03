const fse = require('fs-extra');
const util = require("util");
const rimRaf = util.promisify(require("rimraf"));
const chalk = require('chalk');
const replaceXml = require('./build/replaceXml.js');

const {
	name,
	filename,
	version,
} = require("./package.json");

const manifestFileName = `${filename}.xml`;
const Manifest = `${__dirname}/package/${manifestFileName}`;
const pathMedia = `./media`;

async function cleanOut (cleanOuts) {
	for (const file of cleanOuts)
	{
		await rimRaf(file).then(
			answer => console.log(chalk.redBright(`rimrafed: ${file}.`))
		).catch(error => console.error('Error ' + error));
	}
}

(async function exec()
{
	let cleanOuts = [
		`./package`,
		`./dist`,
	];

	await cleanOut(cleanOuts);
	console.log(chalk.cyanBright(`Be patient! Some copy actions!`));

	await fse.copy(`${pathMedia}`, "./package/media"
	).then(
		answer => console.log(chalk.yellowBright(
			`Copied ${pathMedia} to ./package/media.`))
	);

	await fse.copy("./src", "./package").then(
		answer => console.log(chalk.yellowBright(
			`Copied ./src/* to ./package.`))
	);

	await fse.mkdir("./dist").then(
		answer => console.log(chalk.greenBright(
			`Created ./dist.`))
	);

	const zipFilename = `${name}-${version}.zip`;

	await replaceXml.main(Manifest, zipFilename);
	await fse.copy(`${Manifest}`, `./dist/${manifestFileName}`).then(
		answer => console.log(chalk.yellowBright(
			`Copied ${manifestFileName} to ./dist.`))
	);

	let xmlFile = 'update.xml';
	await fse.copy(`./${xmlFile}`, `./dist/${xmlFile}`).then(
		answer => console.log(chalk.yellowBright(
			`Copied ${xmlFile} to ./dist.`))
	);
	await replaceXml.main(`${__dirname}/dist/${xmlFile}`, zipFilename);

	xmlFile = 'changelog.xml';
	await fse.copy(`./${xmlFile}`, `./dist/${xmlFile}`).then(
		answer => console.log(chalk.yellowBright(
			`Copied ${xmlFile} to ./dist.`))
	);
	await replaceXml.main(`${__dirname}/dist/${xmlFile}`, zipFilename);

	xmlFile = 'release.txt';
	await fse.copy(`./${xmlFile}`, `./dist/${xmlFile}`).then(
		answer => console.log(chalk.yellowBright(
			`Copied ${xmlFile} to ./dist.`))
	);
	await replaceXml.main(`${__dirname}/dist/${xmlFile}`, zipFilename);

	// Zip it
	const zip = new (require("adm-zip"))();
	zip.addLocalFolder("package", false);
	await zip.writeZip(`./dist/${zipFilename}`);
	console.log(chalk.cyanBright(chalk.bgRed(
		`./dist/${zipFilename} written.`)));

	cleanOuts = [
		`./package`,
	];
	await cleanOut(cleanOuts).then(
		answer => console.log(chalk.cyanBright(chalk.bgRed(
			`Finished. Good bye!`)))
	);

})();
