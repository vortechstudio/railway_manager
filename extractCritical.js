import { generate } from 'critical';
import { resolve } from 'path';

const outputDir = resolve(process.cwd(), 'public/css'); // le chemin d'accès à votre fichier css produit par ViteJS
const template = resolve(process.cwd(), 'resources/views/layouts/app.blade.php'); // le template blade principal de votre application

generate({
    base: outputDir,
    src: template,
    width: 1300,
    height: 900,
    target: resolve(outputDir, 'critical.css'),
});
