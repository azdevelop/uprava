<?php
namespace Site\FrontBundle\Twig\Extensions;

/**
* Adds words excerpt filters.
*/
class SiteTwigExtensions extends \Twig_Extension
{
	
	public function getFilters()
	{
		return array(
			'words_excerpt' => new \Twig_Filter_Method($this, 'wordsExcerpt'),
			);
	}
	public function wordsExcerpt($content, $wordsNumber)
	{
		$words = explode(' ', strip_tags($content));
                
		if (is_array($words) && (count($words) > $wordsNumber)) 
		{
			$words = array_slice($words, 0, $wordsNumber);  

			return implode(' ', $words) . '...';
		}
                else return $content;
	}
	
	
	public function getName()
	{
		return 'site_twig_extensions';
	}
}