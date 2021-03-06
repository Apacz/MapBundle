<?php
namespace Apacz\MapBundle\Twig;
/**
 * Created by PhpStorm.
 * User: apacz
 * Date: 13.07.2017
 * Time: 16:13
 */
use Apacz\MapBundle\Interfaces\iGeographicalCoordinates;

class GoogleMapTwig extends \Twig_Extension
{
    protected $googleApiKey;

    protected $zoom ;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct($googleApiKey, $zoom, \Twig_Environment $twig) {
        $this->googleApiKey = $googleApiKey;
        $this->zoom = $zoom;
        $this->twig = $twig;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('gmap', array($this, 'staticMapFilter')),
            new \Twig_SimpleFilter('staticGmap', array($this, 'staticMapFilter')),
            new \Twig_SimpleFilter('markerGmap', array($this, 'markerMapFilter')),
        );
    }

    /**
     * @param iGeographicalCoordinates $coordinates
     * @param int $width
     * @param int $height
     * @return mixed|string
     */
    public function staticMapFilter(iGeographicalCoordinates $coordinates, $width = 100, $height = 100)
    {
        $content = $this->twig->render(
            'ApaczMapBundle:GoogleMap:template.html.twig',
            array('zoom' => $this->zoom, 'key' => $this->googleApiKey, 'coordinates' => $coordinates,
                'width' => $width, 'height' => $height)
        );

        return $content;
    }

    /**
     * @param iGeographicalCoordinates $coordinates
     * @param int $width
     * @param int $height
     * @return mixed|string
     */
    public function markerMapFilter(iGeographicalCoordinates $coordinates, $width = 100, $height = 100, $id = 'map')
    {
        if(is_numeric($width)){
            $width = $width.'px';
        }
        if(is_numeric($height)){
            $height = $height.'px';
        }
        $content = $this->twig->render(
            'ApaczMapBundle:GoogleMap:template-marker.html.twig',
            array('zoom' => $this->zoom, 'key' => $this->googleApiKey, 'coordinates' => $coordinates,
                'width' => $width, 'height' => $height, 'id' => $id)
        );

        return $content;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'google_map_twig_extension';
    }
}