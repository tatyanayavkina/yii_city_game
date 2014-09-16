<?php
Class WikiUtils  {

    private static $REG_CITY_SEARCH = "/Город/";

    public static function getWikiPage($wikiQuery)
    {
        libxml_use_internal_errors(true);
        $url = 'http://ru.wikipedia.org/wiki/' . rawurlencode($wikiQuery);
        $page = @file_get_contents($url);
        if ($page === FALSE) {
            throw new Exception('file_get_contents вернул FALSE');
        }
        $encodedPage = mb_convert_encoding($page, 'HTML-ENTITIES', 'UTF-8');
        $doc = new DomDocument();
        $doc->loadHTML($encodedPage);

        return $doc;
    }

    public static function getFirstWikiArticleParagraph($wikiQuery)
    {
        $doc = self::getWikiPage($wikiQuery);
        $parentDiv = $doc->getElementById('mw-content-text');
        $parentDivChildren = $parentDiv->childNodes;

        foreach($parentDivChildren as $parentDivChild)
        {
            if ($parentDivChild->nodeName === 'table')
                return $parentDivChild->textContent; // или nodeValue
        }

    }

    public static function checkCityByWiki($cityName)
    {
        try
        {
            $paragraph = self::getFirstWikiArticleParagraph($cityName);
            if(self::CheckParagraphForCity($paragraph))
            {
                return true;
            }
        }
        catch(Exception $e)
        {
        }

        return false;
    }

    public static function  CheckParagraphForCity($paragraph)
    {
        return preg_match(self::$REG_CITY_SEARCH,$paragraph);
        // в этом абзаце убедиться, что есть длинное тире, потом 1 и более whitespaces, потом слово 'город' /—\s*? город /
    }

}
?>