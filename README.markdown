# Sort Data Source by Parameters

- Version: 1.2
- Author: Marcin Konicki (http://ahwayakchih.neoni.net)
- Build Date: 27 July 2013
- Requirements: Symphony version 2.3.3 or later.
- Text rendered on screenshots was rendered with Lobster font (http://www.impallari.com/lobster/) created by Pablo Impallari.

## Overview

Modifies Data Source edit page to allow entering parameters to be used for sort and order options.

## Installation

1. Upload the 'sortdatasourcebyparam' folder in this archive to your Symphony 'extensions' folder.
2. Enable it by selecting the "Sort Data Source by Parameters", choose Enable from the with-selected menu, then click Apply.

## Usage

Use parameter syntax to sort results by field name found in the paremeter value. For example:

`{$url-sort-by:title}`

will sort entries by field specified in the "sort-by" URL parameter, or fallback to "title" field by default.

Same for sort order:

`{$url-sort-order:asc}`

will sort using order specified in the "sort-order" URL parameter, or fallback to "asc" (ascending) order by default.

## Changelog

- **1.2** Update for Symphony 2.3.3.
- **1.1** Update for Symphony 2.3.
- **1.0** Initial release.



