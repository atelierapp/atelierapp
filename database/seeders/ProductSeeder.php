<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Style;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $productsExcel = collect([
            ['sku' => 'BSE0001', 'title' => 'Madeline Poster', 'category' => 'Bed', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '82.5', 'depth' => '90.75', 'height' => '92', 'price' => '3746', 'front' => 'BSE0001-F', 'side' => '-', 'pers' => 'BSE0001-P'],
            ['sku' => 'BSE0002', 'title' => 'Florida Chair ', 'category' => 'Chair', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Mediterranean', 'width' => '29.92', 'depth' => '29.92', 'height' => '33.86', 'price' => '338', 'front' => '-', 'side' => 'BSE0002-S', 'pers' => 'BSE0002-P'],
            ['sku' => 'BSE0003', 'title' => 'Milo Chair', 'category' => 'Chair', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Rustic', 'width' => '31.5', 'depth' => '37', 'height' => '39', 'price' => '2388', 'front' => '-', 'side' => '-', 'pers' => 'BSE0003-P'],
            ['sku' => 'BSE0004', 'title' => 'Maison Occasional Chair', 'category' => 'Chair', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '40', 'depth' => '28', 'height' => '35.5', 'price' => '1705', 'front' => 'BSE0004-F', 'side' => '-', 'pers' => 'BSE0004-P'],
            ['sku' => 'BSE0005', 'title' => 'Lara Coffee Table ', 'category' => 'Coffee Table', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '47.5', 'depth' => '29.5', 'height' => '19.5', 'price' => '1933', 'front' => 'BSE0005-F', 'side' => '-', 'pers' => 'BSE0005-P'],
            ['sku' => 'BSE0006', 'title' => 'Sirah Wood', 'category' => 'Coffee Table', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Traditional', 'width' => '30.5', 'depth' => '30.5', 'height' => '15.75', 'price' => '1997.5', 'front' => '-', 'side' => '-', 'pers' => 'BSE0006-P'],
            ['sku' => 'BSE0007', 'title' => 'Game of Thornes', 'category' => 'Console', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Rustic', 'width' => '62', 'depth' => '16', 'height' => '32', 'price' => '1533', 'front' => 'BSE0007-F', 'side' => '-', 'pers' => 'BSE0007-P'],
            ['sku' => 'BSE0008', 'title' => 'Soho Media', 'category' => 'Console', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Contemporary', 'width' => '82', 'depth' => '18', 'height' => '34', 'price' => '4534', 'front' => 'BSE0008-F', 'side' => 'BSE0008-S', 'pers' => 'BSE0008-P'],
            ['sku' => 'BSE0009', 'title' => 'Moses', 'category' => 'Console', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '49.5', 'depth' => '23', 'height' => '31', 'price' => '1819', 'front' => 'BSE0009-F', 'side' => '-', 'pers' => 'BSE0009-P'],
            ['sku' => 'BSE0010', 'title' => 'Game of Thornes', 'category' => 'Desk', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Traditional', 'width' => '62', 'depth' => '37', 'height' => '32', 'price' => '2667', 'front' => 'BSE0010-F', 'side' => '-', 'pers' => 'BSE0010-P'],
            ['sku' => 'BSE0011', 'title' => 'The Harley Chair', 'category' => 'Dining Chair', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Rustic', 'width' => '23', 'depth' => '23', 'height' => '33', 'price' => '1029', 'front' => 'BSE0011-F', 'side' => 'BSE0011-S', 'pers' => 'BSE0011-P'],
            ['sku' => 'BSE0012', 'title' => 'Medallion Side Chair', 'category' => 'Dining Chair', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '21', 'depth' => '21', 'height' => '40', 'price' => '675', 'front' => 'BSE0012-F', 'side' => '-', 'pers' => 'BSE0012-P'],
            ['sku' => 'BSE0013', 'title' => 'Sophie', 'category' => 'Dining Chair', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Traditional', 'width' => '20', 'depth' => '17', 'height' => '38', 'price' => '1008', 'front' => 'BSE0013-F', 'side' => 'BSE0013-S', 'pers' => 'BSE0013-P'],
            ['sku' => 'BSE0014', 'title' => 'Oval - White Wash + Natural Wood -', 'category' => 'Dining Table', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '89', 'depth' => '39', 'height' => '30', 'price' => '2562', 'front' => 'BSE0014-F', 'side' => 'BSE0014-S', 'pers' => 'BSE0014-P'],
            ['sku' => 'BSE0015', 'title' => 'Southport Dresser', 'category' => 'Dresser', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Mid Century Modern ', 'width' => '72', 'depth' => '18', 'height' => '36.25', 'price' => '2245', 'front' => '-', 'side' => 'BSE0015-S', 'pers' => 'BSE0015-P'],
            ['sku' => 'BSE0016', 'title' => 'Three Drawer', 'category' => 'Nightstand', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Mediterranean', 'width' => '25', 'depth' => '15', 'height' => '30', 'price' => '530', 'front' => 'BSE0016-F', 'side' => '-', 'pers' => '-'],
            ['sku' => 'BSE0017', 'title' => 'Antique White + Natural Pine', 'category' => 'Nightstand', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '20', 'depth' => '18', 'height' => '33', 'price' => '997', 'front' => 'BSE0017-F', 'side' => '-', 'pers' => 'BSE0017-P'],
            ['sku' => 'BSE0018', 'title' => 'Barrington', 'category' => 'Nightstand', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Eclectic', 'width' => '34', 'depth' => '19', 'height' => '30', 'price' => '1688', 'front' => '-', 'side' => '-', 'pers' => 'BSE0018-P'],
            ['sku' => 'BSE0019', 'title' => 'Square Tufted', 'category' => 'Ottoman', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '39.5', 'depth' => '39.5', 'height' => '16.5', 'price' => '1315', 'front' => 'BSE0019-F', 'side' => '-', 'pers' => 'BSE0019-P'],
            ['sku' => 'BSE0020', 'title' => 'Chaline', 'category' => 'Shelf', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '33.5', 'depth' => '2', 'height' => '91.5', 'price' => '3878', 'front' => 'BSE0020-F', 'side' => '-', 'pers' => 'BSE0020-P'],
            ['sku' => 'BSE0021', 'title' => 'Bookcase - Refined Arches Tall', 'category' => 'Shelf', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Traditional', 'width' => '50', 'depth' => '18', 'height' => '91', 'price' => '4061', 'front' => 'BSE0021-F', 'side' => '-', 'pers' => 'BSE0021-P'],
            ['sku' => 'BSE0022', 'title' => 'Castered Chesterfield', 'category' => 'Sofa', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Rustic', 'width' => '89', 'depth' => '38', 'height' => '32', 'price' => '4744', 'front' => 'BSE0022-F', 'side' => 'BSE0022-S', 'pers' => 'BSE0022-P'],
            ['sku' => 'BSE0023', 'title' => 'Adele', 'category' => 'Sofa', 'store' => 'Blue Sky Environments Interior Decor', 'style' => 'Shabby Chic', 'width' => '78', 'depth' => '41', 'height' => '31', 'price' => '2963', 'front' => 'BSE0023-F', 'side' => '-', 'pers' => 'BSE0023-P'],

            ['sku' => 'BD0001', 'title' => 'Allegra ', 'category' => 'Bed', 'store' => 'Burke Decor', 'style' => 'Mediterranean', 'width' => '63', 'depth' => '84', 'height' => '48', 'price' => '1399', 'front' => 'BD0001-F', 'side' => 'BD0001-S', 'pers' => 'BD0001-P'],
            ['sku' => 'BD0002', 'title' => 'Aidan Upholstered ', 'category' => 'Bed', 'store' => 'Burke Decor', 'style' => 'Rustic', 'width' => '65.25', 'depth' => '93.75', 'height' => '35.5', 'price' => '1299', 'front' => 'BD0002-F', 'side' => 'BD0002-S', 'pers' => 'BD0002-P'],
            ['sku' => 'BD0003', 'title' => 'Jefferson Bed in Indigo', 'category' => 'Bed', 'store' => 'Burke Decor', 'style' => 'Glam', 'width' => '66.25', 'depth' => '88.5', 'height' => '60', 'price' => '1949', 'front' => 'BD0003-F', 'side' => 'BD0003-S', 'pers' => 'BD0003-P'],
            ['sku' => 'BD0004', 'title' => 'Harrington ', 'category' => 'Bed', 'store' => 'Burke Decor', 'style' => 'Mid Century Modern ', 'width' => '62.5', 'depth' => '83.75', 'height' => '45.25', 'price' => '1199', 'front' => 'BD0004-F', 'side' => 'BD0004-S', 'pers' => 'BD0004-P'],
            ['sku' => 'BD0005', 'title' => 'Cyrus Occasional Chair', 'category' => 'Chair', 'store' => 'Burke Decor', 'style' => 'Mid Century Modern ', 'width' => '28.3', 'depth' => '28.8', 'height' => '26.5', 'price' => '1395', 'front' => 'BD0005-F', 'side' => 'BD0005-S', 'pers' => 'BD0005-P'],
            ['sku' => 'BD0006', 'title' => 'Benton Coffee Table', 'category' => 'Coffee Table', 'store' => 'Burke Decor', 'style' => 'Rustic', 'width' => '64.5', 'depth' => '32.5', 'height' => '18.5', 'price' => '2167', 'front' => 'BD0006-F', 'side' => 'BD0006-S', 'pers' => 'BD0006-P'],
            ['sku' => 'BD0007', 'title' => 'Solana Oval Coffee Table ', 'category' => 'Coffee Table', 'store' => 'Burke Decor', 'style' => 'Mid Century Modern ', 'width' => '59', 'depth' => '21', 'height' => '12', 'price' => '950', 'front' => 'BD0007-F', 'side' => '-', 'pers' => 'BD0007-P'],
            ['sku' => 'BD0008', 'title' => 'Americana Coffee Table ', 'category' => 'Coffee Table', 'store' => 'Burke Decor', 'style' => 'Contemporary', 'width' => '32', 'depth' => '32', 'height' => '18', 'price' => '724.5', 'front' => '-', 'side' => '-', 'pers' => 'BD0008-P'],
            ['sku' => 'BD0009', 'title' => 'Hendrick Console Table', 'category' => 'Console', 'store' => 'Burke Decor', 'style' => 'Mid Century Modern ', 'width' => '50', 'depth' => '11', 'height' => '31', 'price' => '749', 'front' => 'BD0009-F', 'side' => 'BD0009-S', 'pers' => 'BD0009-P'],
            ['sku' => 'BD0010', 'title' => 'Clarke 1 Drawer Console Table', 'category' => 'Console', 'store' => 'Burke Decor', 'style' => 'Eclectic', 'width' => '48', 'depth' => '18', 'height' => '30', 'price' => '2295', 'front' => '-', 'side' => '-', 'pers' => 'BD0010-P'],
            ['sku' => 'BD0011', 'title' => 'Graf Console in Pale', 'category' => 'Console', 'store' => 'Burke Decor', 'style' => 'Traditional', 'width' => '72', 'depth' => '22', 'height' => '32', 'price' => '2520', 'front' => 'BD0011-F', 'side' => '-', 'pers' => '-'],
            ['sku' => 'BD0012', 'title' => 'Carmel Desk', 'category' => 'Desk', 'store' => 'Burke Decor', 'style' => 'Mediterranean', 'width' => '60', 'depth' => '22', 'height' => '30', 'price' => '1199', 'front' => 'BD0012-F', 'side' => 'BD0012-S', 'pers' => 'BD0012-P'],
            ['sku' => 'BD0013', 'title' => 'Cher Desk', 'category' => 'Desk', 'store' => 'Burke Decor', 'style' => 'Rustic', 'width' => '64', 'depth' => '21', 'height' => '30', 'price' => '1799', 'front' => 'BD0013-F', 'side' => 'BD0013-S', 'pers' => 'BD0013-P'],
            ['sku' => 'BD0014', 'title' => 'Campaign Desk in Pale', 'category' => 'Desk', 'store' => 'Burke Decor', 'style' => 'Eclectic', 'width' => '70', 'depth' => '32', 'height' => '30', 'price' => '2251', 'front' => 'BD0014-F', 'side' => 'BD0014-S', 'pers' => 'BD0014-P'],
            ['sku' => 'BD0015', 'title' => 'Fota Side Chair', 'category' => 'Dining Chair', 'store' => 'Burke Decor', 'style' => 'Mediterranean', 'width' => '19.5', 'depth' => '24.5', 'height' => '34', 'price' => '385', 'front' => '-', 'side' => 'BD0015-S', 'pers' => 'BD0015-P'],
            ['sku' => 'BD0016', 'title' => 'Carrie Dining Chair', 'category' => 'Dining Chair', 'store' => 'Burke Decor', 'style' => 'Glam', 'width' => '25.5', 'depth' => '23', 'height' => '27.5', 'price' => '699', 'front' => 'BD0016-F', 'side' => 'BD0016-S', 'pers' => 'BD0016-P'],
            ['sku' => 'BD0017', 'title' => 'Laurel Dining Table in Natural', 'category' => 'Dining Table', 'store' => 'Burke Decor', 'style' => 'Mediterranean', 'width' => '84', 'depth' => '40', 'height' => '30', 'price' => '2021.7', 'front' => 'BD0017-F', 'side' => '-', 'pers' => 'BD0017-P'],
            ['sku' => 'BD0018', 'title' => 'Glover Dining Table', 'category' => 'Dining Table', 'store' => 'Burke Decor', 'style' => 'Rustic', 'width' => '94', 'depth' => '42', 'height' => '30', 'price' => '2299', 'front' => 'BD0018-F', 'side' => 'BD0018-S', 'pers' => 'BD0018-P'],
            ['sku' => 'BD0019', 'title' => 'Arden Dining Table', 'category' => 'Dining Table', 'store' => 'Burke Decor', 'style' => 'Eclectic', 'width' => '54', 'depth' => '54', 'height' => '30', 'price' => '1263', 'front' => '-', 'side' => '-', 'pers' => 'BD0019-P'],
            ['sku' => 'BD0020', 'title' => 'Castle in Bleached Pine', 'category' => 'Dining Table', 'store' => 'Burke Decor', 'style' => 'Traditional', 'width' => '98', 'depth' => '39.25', 'height' => '30.75', 'price' => '3099', 'front' => 'BD0020-F', 'side' => '-', 'pers' => 'BD0020-P'],
            ['sku' => 'BD0021', 'title' => 'Drake Bed Luxe in Taupe', 'category' => 'Bed', 'store' => 'Burke Decor', 'style' => 'Traditional', 'width' => '65', 'depth' => '87', 'height' => '58', 'price' => '3030', 'front' => '-', 'side' => '-', 'pers' => 'BD0021-P'],
            ['sku' => 'BD0022', 'title' => 'Allegra 8 Drawer Dresser', 'category' => 'Dresser', 'store' => 'Burke Decor', 'style' => 'Mediterranean', 'width' => '61', 'depth' => '18', 'height' => '33', 'price' => '1146.65', 'front' => '-', 'side' => 'BD0022-S', 'pers' => 'BD0022-P'],
            ['sku' => 'BD0023', 'title' => 'Carly 6 Drawer Dresser', 'category' => 'Dresser', 'store' => 'Burke Decor', 'style' => 'Contemporary', 'width' => '62', 'depth' => '18', 'height' => '31.25', 'price' => '1499', 'front' => 'BD0023-F', 'side' => 'BD0023-S', 'pers' => 'BD0023-P'],
            ['sku' => 'BD0024', 'title' => 'Classic Dresser', 'category' => 'Dresser', 'store' => 'Burke Decor', 'style' => 'Shabby Chic', 'width' => '44', 'depth' => '22', 'height' => '37', 'price' => '3585', 'front' => '-', 'side' => '-', 'pers' => 'BD0024-P'],
            ['sku' => 'BD0025', 'title' => 'Gaspard', 'category' => 'Nightstand', 'store' => 'Burke Decor', 'style' => 'Glam', 'width' => '30', 'depth' => '19', 'height' => '30', 'price' => '3337.2', 'front' => '-', 'side' => '-', 'pers' => 'BD0025-P'],
            ['sku' => 'BD0026', 'title' => 'Hendrick', 'category' => 'Nightstand', 'store' => 'Burke Decor', 'style' => 'Mid Century Modern ', 'width' => '23', 'depth' => '16', 'height' => '25', 'price' => '529', 'front' => 'BD0026-F', 'side' => 'BD0026-S', 'pers' => 'BD0026-P'],
            ['sku' => 'BD0027', 'title' => 'Carly C', 'category' => 'Nightstand', 'store' => 'Burke Decor', 'style' => 'Contemporary', 'width' => '18', 'depth' => '15', 'height' => '25', 'price' => '329', 'front' => 'BD0027-F', 'side' => 'BD0027-S', 'pers' => 'BD0027-P'],
            ['sku' => 'BD0028', 'title' => 'Cintra', 'category' => 'Nightstand', 'store' => 'Burke Decor', 'style' => 'Traditional', 'width' => '19.75', 'depth' => '16.75', 'height' => '27.5', 'price' => '379', 'front' => 'BD0028-F', 'side' => 'BD0028-S', 'pers' => 'BD0028-P'],
            ['sku' => 'BD0029', 'title' => 'Thistle', 'category' => 'Ottoman', 'store' => 'Burke Decor', 'style' => 'Traditional', 'width' => '36', 'depth' => '36', 'height' => '17', 'price' => '1098', 'front' => 'BD0029-F', 'side' => '-', 'pers' => 'BD0029-P'],
            ['sku' => 'BD0030', 'title' => 'Babs', 'category' => 'Shelf', 'store' => 'Burke Decor', 'style' => 'Mediterranean', 'width' => '57', 'depth' => '17', 'height' => '59.5', 'price' => '849', 'front' => 'BD0030-F', 'side' => 'BD0030-S', 'pers' => 'BD0030-P'],
            ['sku' => 'BD0031', 'title' => 'Bullerswood Etagere', 'category' => 'Shelf', 'store' => 'Burke Decor', 'style' => 'Rustic', 'width' => '32', 'depth' => '18', 'height' => '80', 'price' => '1995', 'front' => 'BD0031-F', 'side' => '-', 'pers' => 'BD0031-P'],
            ['sku' => 'BD0032', 'title' => 'Siam Étagère', 'category' => 'Shelf', 'store' => 'Burke Decor', 'style' => 'Glam', 'width' => '30', 'depth' => '16', 'height' => '84', 'price' => '2995', 'front' => 'BD0032-F', 'side' => 'BD0032-S', 'pers' => '-'],
            ['sku' => 'BD0033', 'title' => 'Bass', 'category' => 'Shelf', 'store' => 'Burke Decor', 'style' => 'Mid Century Modern ', 'width' => '35.5', 'depth' => '14', 'height' => '64', 'price' => '1353', 'front' => 'BD0033-F', 'side' => 'BD0033-S', 'pers' => 'BD0033-P'],
            ['sku' => 'BD0034', 'title' => 'Teak Varnished', 'category' => 'Shelf', 'store' => 'Burke Decor', 'style' => 'Contemporary', 'width' => '47', 'depth' => '16', 'height' => '81', 'price' => '2459', 'front' => 'BD0034-F', 'side' => '-', 'pers' => 'BD0034-P'],
            ['sku' => 'BD0035', 'title' => 'Large Argan', 'category' => 'Side Table', 'store' => 'Burke Decor', 'style' => 'Mediterranean', 'width' => '17', 'depth' => '20', 'height' => '18', 'price' => '540.5', 'front' => '-', 'side' => '-', 'pers' => 'BD0035-P'],
            ['sku' => 'BD0036', 'title' => 'Hudson', 'category' => 'Side Table', 'store' => 'Burke Decor', 'style' => 'Rustic', 'width' => '20', 'depth' => '20', 'height' => '21', 'price' => '849', 'front' => 'BD0036-F', 'side' => '-', 'pers' => '-'],
            ['sku' => 'BD0037', 'title' => 'Barclay Cigar', 'category' => 'Side Table', 'store' => 'Burke Decor', 'style' => 'Shabby Chic', 'width' => '11.5', 'depth' => '11.5', 'height' => '24', 'price' => '399', 'front' => '-', 'side' => '-', 'pers' => 'BD0037-P'],
            ['sku' => 'BD0038', 'title' => 'Lucy', 'category' => 'Side Table', 'store' => 'Burke Decor', 'style' => 'Traditional', 'width' => '24', 'depth' => '24', 'height' => '26', 'price' => '699', 'front' => 'BD0038-F', 'side' => '-', 'pers' => '-'],
            ['sku' => 'BD0039', 'title' => 'Grammercy', 'category' => 'Sofa', 'store' => 'Burke Decor', 'style' => 'Contemporary', 'width' => '92', 'depth' => '39', 'height' => '24', 'price' => '1699', 'front' => 'BD0039-F', 'side' => 'BD0039-S', 'pers' => 'BD0039-P'],
            ['sku' => 'BD0040', 'title' => 'Day Bed', 'category' => 'Sofa', 'store' => 'Burke Decor', 'style' => 'Traditional', 'width' => '83.75', 'depth' => '53.25', 'height' => '29', 'price' => '3299', 'front' => 'BD0040-F', 'side' => 'BD0040-S', 'pers' => 'BD0040-P'],

            ['sku' => 'EM0001', 'title' => 'Husk Bed', 'category' => 'Bed', 'store' => 'Eternity Modern', 'style' => 'Contemporary', 'width' => '70.2', 'depth' => '89', 'height' => '42.1', 'price' => '4079', 'front' => 'EM0001-F', 'side' => 'EM0001-S', 'pers' => 'EM0001-P'],
            ['sku' => 'EM0002', 'title' => 'Tom Dixon Scoop Chair', 'category' => 'Chair', 'store' => 'Eternity Modern', 'style' => 'Contemporary', 'width' => '25.2', 'depth' => '22.4', 'height' => '29.5', 'price' => '729', 'front' => 'EM0002-F', 'side' => 'EM0002-S', 'pers' => 'EM0002-P'],
            ['sku' => 'EM0003', 'title' => 'Warren Platner Lounge Chair - Gun Metal Black Base', 'category' => 'Chair', 'store' => 'Eternity Modern', 'style' => 'Eclectic', 'width' => '33', 'depth' => '24', 'height' => '27', 'price' => '2299', 'front' => 'EM0003-F', 'side' => '-', 'pers' => 'EM0003-P'],
            ['sku' => 'EM0004', 'title' => 'Angie', 'category' => 'Dining Chair', 'store' => 'Eternity Modern', 'style' => 'Contemporary', 'width' => '25', 'depth' => '24', 'height' => '32', 'price' => '1269', 'front' => 'EM0004-F', 'side' => 'EM0004-S', 'pers' => 'EM0004-P'],
            ['sku' => 'EM0005', 'title' => 'Platner Coffee Table - 36"', 'category' => 'Coffee Table', 'store' => 'Eternity Modern', 'style' => 'Eclectic', 'width' => '36', 'depth' => '36', 'height' => '15.25', 'price' => '999', 'front' => '-', 'side' => '-', 'pers' => 'EM0005-P'],
            ['sku' => 'EM0006', 'title' => 'Finn Juhl Nyhavn Des', 'category' => 'Desk', 'store' => 'Eternity Modern', 'style' => 'Mid Century Modern ', 'width' => '70.9', 'depth' => '29.5', 'height' => '28.7', 'price' => '2299', 'front' => 'EM0006-F', 'side' => 'EM0006-S', 'pers' => 'EM0006-P'],
            ['sku' => 'EM0007', 'title' => 'Naver 1340 Desk', 'category' => 'Desk', 'store' => 'Eternity Modern', 'style' => 'Contemporary', 'width' => '70.9', 'depth' => '31.5', 'height' => '29.5', 'price' => '1989', 'front' => 'EM0007-F', 'side' => 'EM0007-S', 'pers' => 'EM0007-P'],
            ['sku' => 'EM0008', 'title' => 'Pierre Jeanneret', 'category' => 'Dining Chair', 'store' => 'Eternity Modern', 'style' => 'Mid Century Modern ', 'width' => '21.3', 'depth' => '22.4', 'height' => '30.7', 'price' => '699', 'front' => 'EM0008-F', 'side' => 'EM0008-S', 'pers' => 'EM0008-P'],
            ['sku' => 'EM0009', 'title' => 'Tulip Side Chair - Fiberglass', 'category' => 'Dining Chair', 'store' => 'Eternity Modern', 'style' => 'Contemporary', 'width' => '19.29', 'depth' => '20.07', 'height' => '32', 'price' => '509', 'front' => 'EM0009-F', 'side' => 'EM0009-S', 'pers' => '-'],
            ['sku' => 'EM0010', 'title' => 'Drop Chair - Upholstered', 'category' => 'Dining Chair', 'store' => 'Eternity Modern', 'style' => 'Eclectic', 'width' => '18', 'depth' => '21.5', 'height' => '35', 'price' => '569', 'front' => 'EM0010-F', 'side' => 'EM0010-S', 'pers' => 'EM0010-P'],
            ['sku' => 'EM0011', 'title' => 'CH327 Hans Wegner ', 'category' => 'Dining Table', 'store' => 'Eternity Modern', 'style' => 'Mid Century Modern ', 'width' => '74.8', 'depth' => '35.4', 'height' => '29.5', 'price' => '1899', 'front' => 'EM0011-F', 'side' => '-', 'pers' => 'EM0011-P'],
            ['sku' => 'EM0012', 'title' => 'Borge Mogensen Wingback', 'category' => 'Ottoman', 'store' => 'Eternity Modern', 'style' => 'Rustic', 'width' => '23', 'depth' => '23', 'height' => '17', 'price' => '569', 'front' => '-', 'side' => 'EM0012-S', 'pers' => 'EM0012-P'],
            ['sku' => 'EM0013', 'title' => 'Pierre Jeanneret', 'category' => 'Ottoman', 'store' => 'Eternity Modern', 'style' => 'Mid Century Modern ', 'width' => '53.5', 'depth' => '15.7', 'height' => '17', 'price' => '1789', 'front' => 'EM0013-F', 'side' => 'EM0013-S', 'pers' => 'EM0013-P'],
            ['sku' => 'EM0014', 'title' => 'Cleo', 'category' => 'Sofa', 'store' => 'Eternity Modern', 'style' => 'Eclectic', 'width' => '75', 'depth' => '33', 'height' => '29', 'price' => '2849', 'front' => 'EM0014-F', 'side' => 'EM0014-S', 'pers' => 'EM0014-P'],

            ['sku' => 'MS0001', 'title' => 'St. Germain', 'category' => 'Bed', 'store' => 'Modshop', 'style' => 'Eclectic', 'width' => '94', 'depth' => '86', 'height' => '68', 'price' => '3595', 'front' => 'MS0001-F', 'side' => '-', 'pers' => 'MS0001-P'],
            ['sku' => 'MS0002', 'title' => 'La Fontanella Occasional Chair', 'category' => 'Chair', 'store' => 'Modshop', 'style' => 'Glam', 'width' => '30', 'depth' => '30', 'height' => '32', 'price' => '1195', 'front' => 'MS0002-F', 'side' => 'MS0002-S', 'pers' => 'MS0002-P'],
            ['sku' => 'MS0003', 'title' => 'Monaco Wing Chair in Tweed', 'category' => 'Chair', 'store' => 'Modshop', 'style' => 'Traditional', 'width' => '31', 'depth' => '28', 'height' => '69', 'price' => '2295', 'front' => 'MS0003-F', 'side' => 'MS0003-S', 'pers' => 'MS0003-P'],
            ['sku' => 'MS0004', 'title' => 'Neutral Agate Credenza', 'category' => 'Console', 'store' => 'Modshop', 'style' => 'Glam', 'width' => '96', 'depth' => '18', 'height' => '28', 'price' => '2695', 'front' => 'MS0004-F', 'side' => '-', 'pers' => 'MS0004-P'],
            ['sku' => 'MS0005', 'title' => 'Cape Town Desk with Marble Top', 'category' => 'Desk', 'store' => 'Modshop', 'style' => 'Glam', 'width' => '60', 'depth' => '30', 'height' => '30.5', 'price' => '3195', 'front' => '-', 'side' => '-', 'pers' => 'MS0005-P'],
            ['sku' => 'MS0006', 'title' => 'Baroque Executive Desk', 'category' => 'Desk', 'store' => 'Modshop', 'style' => 'Shabby Chic', 'width' => '72', 'depth' => '36', 'height' => '30', 'price' => '3495', 'front' => 'MS0006-F', 'side' => '-', 'pers' => 'MS0006-P'],
            ['sku' => 'MS0007', 'title' => 'Trousdale 2 Oval', 'category' => 'Dining Table', 'store' => 'Modshop', 'style' => 'Glam', 'width' => '96', 'depth' => '40', 'height' => '30', 'price' => '4495', 'front' => 'MS0007-F', 'side' => '-', 'pers' => 'MS0007-P'],
            ['sku' => 'MS0008', 'title' => 'Cody Farmhouse 2', 'category' => 'Dining Table', 'store' => 'Modshop', 'style' => 'Contemporary', 'width' => '96', 'depth' => '42', 'height' => '30', 'price' => '3495', 'front' => '-', 'side' => 'MS0008-S', 'pers' => 'MS0008-P'],
            ['sku' => 'MS0009', 'title' => 'Provence Dresser', 'category' => 'Dresser', 'store' => 'Modshop', 'style' => 'Glam', 'width' => '60', 'depth' => '20', 'height' => '30', 'price' => '2695', 'front' => 'MS0009-F', 'side' => '-', 'pers' => 'MS0009-P'],
            ['sku' => 'MS0010', 'title' => 'Studio 54 Mirrored Dresser', 'category' => 'Dresser', 'store' => 'Modshop', 'style' => 'Eclectic', 'width' => '60', 'depth' => '18', 'height' => '28', 'price' => '2495', 'front' => 'MS0010-F', 'side' => '-', 'pers' => 'MS0010-P'],
            ['sku' => 'MS0011', 'title' => 'Oversized Jet Setter Dresser', 'category' => 'Dresser', 'store' => 'Modshop', 'style' => 'Traditional', 'width' => '84', 'depth' => '19', 'height' => '34.5', 'price' => '3695', 'front' => '-', 'side' => '-', 'pers' => 'MS0011-P'],
            ['sku' => 'MS0012', 'title' => 'Delano', 'category' => 'Ottoman', 'store' => 'Modshop', 'style' => 'Glam', 'width' => '70', 'depth' => '42', 'height' => '18', 'price' => '1495', 'front' => 'MS0012-F', 'side' => 'MS0012-S', 'pers' => 'MS0012-P'],
            ['sku' => 'MS0013', 'title' => 'Corfu', 'category' => 'Ottoman', 'store' => 'Modshop', 'style' => 'Contemporary', 'width' => '65', 'depth' => '20', 'height' => '19', 'price' => '1295', 'front' => 'MS0013-F', 'side' => 'MS0013-S', 'pers' => 'MS0013-P'],
            ['sku' => 'MS0014', 'title' => 'Avalon', 'category' => 'Sofa', 'store' => 'Modshop', 'style' => 'Glam', 'width' => '120', 'depth' => '39', 'height' => '34', 'price' => '3995', 'front' => 'MS0014-F', 'side' => 'MS0014-S', 'pers' => 'MS0014-P'],

            ['sku' => 'WB0001', 'title' => 'Marella Rattan Coffee Table', 'category' => 'Coffee Table', 'store' => 'Winnoby', 'style' => 'Mediterranean', 'width' => '34', 'depth' => '34', 'height' => '19', 'price' => '639', 'front' => '-', 'side' => '-', 'pers' => 'WB0001-P'],
            ['sku' => 'WB0002', 'title' => 'Micah Cocktail Table', 'category' => 'Coffee Table', 'store' => 'Winnoby', 'style' => 'Glam', 'width' => '35', 'depth' => '35', 'height' => '16', 'price' => '775', 'front' => '-', 'side' => '-', 'pers' => 'WB0002-P'],
            ['sku' => 'WB0003', 'title' => 'Arden Reclaimed Pine Dresser', 'category' => 'Dresser', 'store' => 'Winnoby', 'style' => 'Rustic', 'width' => '48.5', 'depth' => '18', 'height' => '34', 'price' => '1175', 'front' => 'WB0003-F', 'side' => 'WB0003-S', 'pers' => 'WB0003-P'],
            ['sku' => 'WB0004', 'title' => 'Arden', 'category' => 'Nightstand', 'store' => 'Winnoby', 'style' => 'Rustic', 'width' => '21.75', 'depth' => '15.75', 'height' => '23.75', 'price' => '445', 'front' => 'WB0004-F', 'side' => 'WB0004-S', 'pers' => 'WB0004-P'],
            ['sku' => 'WB0005', 'title' => 'Bowen', 'category' => 'Sofa', 'store' => 'Winnoby', 'style' => 'Mediterranean', 'width' => '90', 'depth' => '38', 'height' => '35', 'price' => '3409.6', 'front' => 'WB0005-F', 'side' => 'WB0005-S', 'pers' => 'WB0005-P'],

            ['sku' => 'FS0001', 'title' => 'Pffeifer Rattan Console', 'category' => 'Console', 'store' => 'Furbish Studio', 'style' => 'Mediterranean', 'width' => '53.14', 'depth' => '17.71', 'height' => '29.92', 'price' => '465', 'front' => 'FS0001-F', 'side' => 'FS0001-S', 'pers' => 'FS0001-P'],
            ['sku' => 'FS0002', 'title' => 'Malibu Farm Rug Ottoman with Cerused Leg - Grey', 'category' => 'Ottoman', 'store' => 'Furbish Studio', 'style' => 'Mediterranean', 'width' => '47', 'depth' => '26', 'height' => '17', 'price' => '875', 'front' => '-', 'side' => '-', 'pers' => 'FS0002-P'],
            ['sku' => 'FS0003', 'title' => 'Silverlake Rug Ottoman with Cerused Leg', 'category' => 'Ottoman', 'store' => 'Furbish Studio', 'style' => 'Eclectic', 'width' => '47', 'depth' => '26', 'height' => '17', 'price' => '875', 'front' => '-', 'side' => '-', 'pers' => 'FS0003-P'],

            ['sku' => 'BE0001', 'title' => 'Peter C', 'category' => 'Side Table', 'store' => 'Boulevard Eight', 'style' => 'Glam', 'width' => '20', 'depth' => '20', 'height' => '22', 'price' => '757', 'front' => '-', 'side' => 'BE0001-S', 'pers' => 'BE0001-P'],
            ['sku' => 'BE0002', 'title' => 'Jerry C', 'category' => 'Side Table', 'store' => 'Boulevard Eight', 'style' => 'Mid Century Modern ', 'width' => '14', 'depth' => '14', 'height' => '20', 'price' => '322', 'front' => 'BE0002-F', 'side' => '-', 'pers' => 'BE0002-P'],
            ['sku' => 'BE0003', 'title' => 'Gil', 'category' => 'Side Table', 'store' => 'Boulevard Eight', 'style' => 'Contemporary', 'width' => '14', 'depth' => '14', 'height' => '22', 'price' => '733', 'front' => '-', 'side' => '-', 'pers' => 'BE0003-P'],
            ['sku' => 'BE0004', 'title' => 'Debby', 'category' => 'Side Table', 'store' => 'Boulevard Eight', 'style' => 'Eclectic', 'width' => '21.37', 'depth' => '21.37', 'height' => '24', 'price' => '762', 'front' => '-', 'side' => '-', 'pers' => 'BE0004-P'],

            ['sku' => 'SM0001', 'title' => 'Misty', 'category' => 'Sofa', 'store' => 'Sofamania', 'style' => 'Mid Century Modern ', 'width' => '32', 'depth' => '75', 'height' => '30', 'price' => '479.99', 'front' => 'SM0001-F', 'side' => 'SM0001-S', 'pers' => 'SM0001-P'],
        ]);

        $stores = Store::all()->pluck('id', 'name');
        $categories = Category::all();
        $styles = Style::all()->pluck('id', 'name');

        foreach ($productsExcel as $product){
            $product = Product::create([
                'store_id' => $stores[$product['store']],
                'sku' => $product['sku'],
                'title' => $product['title'],
                'style_id' => $styles[$product['style']],
                'price' => $product['price'] * 100,
                'quantity' => random_int(5, 50),
                'properties' => [
                    'dimensions' => [
                        'width' => $product['width'],
                        'depth' => $product['depth'],
                        'height' => $product['height'],
                    ]
                ]
            ]);

            $product->categories()->sync($categories->where('name', '=', $product['category']));

            $views = [
                'front' => '-F',
                'side' => '-S',
                'perspective' => '-P',
            ];
            foreach ($views as $view => $suffix) {
                $product->medias()->create([
                    'url' => Str::of($product->sku)
                        ->prepend('https://atelier-staging-bucket.s3.amazonaws.com/products/')
                        ->append("$suffix.png"),
                    'featured' => $view === 'front',
                    'orientation' => $view,
                    'type_id' => 1,
                ]);
            }
        }
    }
}
