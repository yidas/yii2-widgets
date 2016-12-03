<?php

namespace yidas\widgets;

/**
 * DataTableInfo Widget
 *
 * This widget cloud be used for showing Data Table information such as Total
 * Count or Offset of rows, the data is based on Yii2 Pagination.
 *
 * @author 		Nick Tsai <myintaer@gmail.com>
 * @version 	1.0.1
 * @example
 *  $pagination = new \yii\data\Pagination([]);
 *  echo \yidas\widgets\DataTableInfo::widget(['pagination' => $pagination]);
 */

use Yii;
use yii\base\Widget;

class DataTableInfo extends Widget
{
    /**
     * @var object $pagination yii\data\pagination pagination
     */
    public $pagination;

    /**
     * @var bool $forceDisplay Displaying when no data exist.
     */
    public $forceDisplay = true;

    /**
     * @var string $language Display language
     */
    public $language;

    /**
     * Widget init
     */
    public function init()
    {
        parent::init();

        // Check for Pagination Object
        if ($this->pagination === null) {

            throw new InvalidConfigException('The "pagination" property must be set.');
        }

        // Languge setting
        $this->language = $this->language ? $this->language : Yii::$app->language;
    }

    /**
     * Run the widget
     *
     * @return string 
     */
    public function run()
    {
    	// Set pointer
    	$p = &$this->pagination;

    	// Total rows
    	$total = $p->totalCount;

    	// Force display
        if ($total==0 && !$this->forceDisplay)
            return;

        // Start row at
    	$start = ($total>0) ? $p->getOffset() + 1 : 0;

    	// End row at
        $end = $start + $p->getLimit();
        $end = ($end>$total) ? $total : $end;

        // Output String
    	$message = $this->html($start, $end, $total);

        return $message;
    }

    /**
     * Render HTML string
     *
     * @param int $start
     * @param int $end
     * @param int $total
     * @return string HTML
     */
    private function html($start, $end, $total)
    {
    	switch ($this->language) {

    		case 'zh-TW':
    			return "總資料筆數：{$total} &nbsp;&nbsp; | &nbsp;&nbsp; 顯示資料：{$start} - {$end}";
    			break;
    		
    		case 'en-US':
    		default:
    			return "Showing {$start} to {$end} of {$total} entries";
    			break;
    	}
    }
}