<?php
/**
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package
 * @since
 * @author
 * @version    $Id $
 * die(print_r(get_declared_classes()));--檢查引入物件
 **/
/*-----------引入檔案區--------------*/
use XoopsModules\Tadtools\Utility;
include_once $_SERVER["DOCUMENT_ROOT"] . "/modules/jill_notice/configs/run.inc.php";
if (!$_SESSION['notice_adm']) {
    redirect_header(XOOPS_URL, 3, _MD_JILLNOTICE_ERRORLOGION);
}
$_obj = new PassAction();
$_obj->run();

// /*-----------秀出結果區--------------*/
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
include_once XOOPS_ROOT_PATH . '/footer.php';
