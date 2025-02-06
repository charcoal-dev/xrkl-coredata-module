<?php
declare(strict_types=1);

namespace Charcoal\Framework\Modules\CoreData\Countries\Interfaces;

use Charcoal\Framework\Modules\CoreData\Countries\CountriesTable;

/**
 * Trait ImportCountriesCliTrait
 * @package Charcoal\Framework\Modules\CoreData\Countries\Interfaces
 */
trait ImportCountriesCliTrait
{
    /**
     * @param CountriesTable $countriesTable
     * @param string $pathToCsvFile
     * @return void
     */
    protected function importFromFile(
        CountriesTable $countriesTable,
        string         $pathToCsvFile,
    ): void
    {
        if (!@is_file($pathToCsvFile) || !@is_readable($pathToCsvFile)) {
            throw new \RuntimeException("CSV file not found or not readable");
        }

        $countriesCsv = file_get_contents($pathToCsvFile);
        if (!$countriesCsv) {
            throw new \UnexpectedValueException("Failed to read countries CSV file");
        }

        $countriesCsv = preg_split('(\r\n|\n|\r)', trim($countriesCsv));
        $countriesCount = count($countriesCsv);

        $this->print("");
        $this->print(sprintf("Total Countries Found: {green}{invert}%s{/}", $countriesCount));

        $db = $countriesTable->getDb();
        $saveCountryQuery = "INSERT INTO `" . $countriesTable->name . "` (`status`, `name`, `region`, `code3`, " .
            "`code2`, `dial_code`) VALUES (:status, :name, :region, :code3, :code2, :dialCode) ON DUPLICATE KEY UPDATE " .
            "`name`=:name, `region`=:region, `code3`=:code3, `code2`=:code2, `dial_code`=:dialCode";

        foreach ($countriesCsv as $country) {
            $country = explode(",", $country);
            if (!$country) {
                throw new \RuntimeException("Failed to read a country line");
            }

            $countryData = [
                "status" => 0,
                "name" => $country[0],
                "region" => $country[5],
                "code3" => $country[2],
                "code2" => $country[1],
                "dialCode" => $country[6]
            ];

            $this->inline(sprintf('%s {cyan}%s{/} ... ', $countryData["name"], $countryData["code3"]));

            try {
                $db->exec($saveCountryQuery, $countryData);
                $this->print("{green}SUCCESS{/}");
            } catch (\Exception $e) {
                $this->print("{red}" . $e::class . "{/}");
            }
        }
    }
}