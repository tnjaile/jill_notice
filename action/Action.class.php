<?php
/**
 *
 * @authors jill
 * @date
 * @version
 * @function the base of Controller
 */
use XoopsModules\Tadtools\PageBar;

class Action
{
    protected $_tpl   = null;
    protected $_model = null;

    protected function __construct()
    {
        $this->_tpl   = $GLOBALS['xoopsTpl'];
        $this->_model = Factory::setModel();
    }
    public function run()
    {

        // 判斷權限
        // if ($can_notice) {
        //     $_op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'main';
        // } else {
        //     $_op = 'main';
        // }
        $_op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'main';
        //檢查是否有方法
        method_exists($this, $_op) ? eval('$this->' . $_op . '();') : $this->main();
    }

    // 分頁$_pagesize(每頁幾條)
    // parent::page(2, 10, $this->_notice, array("cate_sn='{$cate_sn}'"));
    protected function page($_pagesize = PAGE_SIZE, $_pagelimit = PAGE_LIMIT, $_model = null, $_where = array())
    {
        $this->_model = Validate::isNullString($_model) ? $this->_model : $_model;

        $_page = new PageBar($this->_model->allNum($_where), $_pagesize, $_pagelimit);

        $_bar = $_page->makeBootStrap3Bar('', $_SESSION['bootstrap']);
        // die(var_dump($_bar));
        $this->_model->setLimit(str_replace('LIMIT ', '', $_bar['sql']));
        $this->_tpl->assign('bar', $_bar);
    }
}
