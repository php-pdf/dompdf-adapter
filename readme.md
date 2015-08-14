# Dompdf Adapter

[![Latest Version](https://img.shields.io/github/release/php-pdf/dompdf-adapter.svg?style=flat-square)](https://github.com/php-pdf/dompdf-adapter/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/php-pdf/dompdf-adapter.svg?style=flat-square)](https://packagist.org/packages/php-pdf/dompdf-adapter)

**Work in progress**

This package aims to provide a common interface for PDF generation, based on plain HTML. It can return a PSR-7 Response object to download/show the pdf, or save it to a path.

```php

$factory = new \Pdf\Adapter\DompdfFactory();
$factory->setDefaultOptions(['paper' => 'a4']);

$pdf = $factory->html('<h1>Hello world!</h1>', ['orientation' => 'landscape']);

$output = $pdf->output();

$response = $pdf->inline('invoice.pdf');

$response = $pdf->attachment('somefile.pdf');

$pdf->save('/some/path/file.pdf');

```
