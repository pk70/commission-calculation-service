# Homework assignment
## Requirements
1. [x] PHP 7.4 minimum.
2. [x] Composer.
3. [x] PHPUnit 9.5.28
4. [x] Enable cURL PHP extension

### Setup project in localhost
- Project url in github `https://github.com/pk70/commission-calculation-service`
- Download file from git or `git clone https://github.com/pk70/commission-calculation-service.git`
- Go to project folder and open terminal
- Run command `composer update`
- Make sure .env file is in root folder
- Run command `php artisan key:generate` for generating encrypted key
- Run command `php artisan serve` you will see url `http://127.0.0.1:8000/`

### Live link
- http://commission-calculation.discovernanosoft.com/

### How to operate the project/software
- Open url in browser (`http://127.0.0.1:8000/`)
- Click the `Calculation with existing file` you will get the expected result
- Or you can upload a csv file by choosing csv file input field (upload expected formated file) and then click upload (please upload csv file as expected format)
- After uploading latest file click the button `Calculation with latest uploaded file` you will get the expected result
- You can also download the result as csv format by clicking `Download calculated Csv` button.
- The input.csv file store inside storage folder you can change it manually also (rootdirectory/storage/).

### Folder structure
- Inside root folder/storage folder input and output csv file stored.
- Inside root folder/routes folder there is `web.php` file, where all routes were written.
- Inside root folder/app/Http/Controllers folder where all php classes controller were written.
- Inside root folder/app/Services folder where all php classes as services were written.
- Inside root folder/tests/Feature folder where all php unit test class were written.

### PHP Unit test
- Run command  `./vendor/bin/phpunit` in project terminal for unit testing result.
- For specific test  `./vendor/bin/phpunit --filter HomePageTest` in project terminal for unit testing result.
- The were 3 feature test class 
1.HomePageTest where two methood for testing `test_landing_page,test_download_page`(landing page and download csv testing)
2.CalculationTest where one method for testing `test_calculation_by_csv_array` (existing csv file get calculated expected output testing)
3.InputFileTest where one method for testing `test_input_file_exists` (input.csv existing testing)

### Technology used
- Laravel framework version 8

