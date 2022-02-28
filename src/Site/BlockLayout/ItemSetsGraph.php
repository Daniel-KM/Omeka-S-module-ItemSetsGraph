<?php
namespace ItemSetsGraph\Site\BlockLayout;

use Laminas\Form\Element\Select;
use Laminas\Form\Element\Text;
use Omeka\Form\Element\HtmlTextarea;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Api\Representation\ItemSetRepresentation;
use Omeka\Api\Representation\ItemRepresentation;
use Omeka\Mvc\Controller\Plugin\Api;
use Omeka\Entity\SitePageBlock;
use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Stdlib\ErrorStore;
use Zend\View\Renderer\PhpRenderer;
use Zend\ServiceManager\ServiceLocatorInterface;

class ItemSetsGraph extends AbstractBlockLayout
{
    
    public function getLabel()
    {
        return 'Item Sets Graph'; // @translate
    }

    public function prepareForm(PhpRenderer $view)
    {
        $view->headLink()->appendStylesheet($view->assetUrl('css/item-sets-graph-admin.css', 'ItemSetsGraph'));
    }
    
    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null) {
        $html = '';
        $json = new HtmlTextarea("o:block[__blockIndex__][o:data][item_sets_graph_json]");
        
        if ($block && $block->dataValue('item_sets_graph_json')) {
            $json->setAttribute('value', $block->dataValue('item_sets_graph_json'));
        }

        $html .= '<div class="field"><div class="field-meta">';
        $html .= '<label>' . $view->translate('Item Sets') . '</label>';
        $html .= '<a href="#" class="collapse" aria-label="Collapse" title="Collapse"></a>';
        $html .= '<div class="collapsible"><div class="field-description">'. $view->translate('Follow the structure: <br>Item Set Id, Hex color \n') . '</div></div>';
        $html .= '</div>';
        $html .= '<div class="inputs">' . $view->formRow($json) . '</div>';
        $html .= '</div>';
        
        return $html;
    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        $view->headLink()->appendStylesheet($view->assetUrl('style.css', 'ItemSetsGraph'));
        $view->headScript()->appendFile($view->assetUrl('style.js', 'ItemSetsGraph'), 'text/javascript');
        
        return $view->partial('common/block-layout/item-sets-graph-block', [
            'block' => $block,
            'json' => $block->dataValue('item_sets_graph_json'),
            'itemSets' => $response
        ]);
    }
}