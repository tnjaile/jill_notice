    //判斷目前登入者在哪些類別中有發表的權利
    public function chk_user_cate_power($kind = 'post')
    {
        global $xoopsDB, $xoopsUser;
        if (empty($xoopsUser)) {
            return false;
        }
        $isAdmin = $xoopsUser->isAdmin($this->module_id);
        if ($isAdmin) {
            $ok_cat[] = 0;
        }
        $user_array = $xoopsUser->getGroups();
        $col = ('post' === $kind) ? 'enable_post_group' : 'enable_group';
        //非管理員才要檢查
        $where = ($isAdmin) ? '' : "where $col!=''";
        $sql = "select ncsn,{$col} from " . $xoopsDB->prefix('tad_news_cate') . " $where";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($ncsn, $power) = $xoopsDB->fetchRow($result)) {
            if ($isAdmin or 'pass' === $kind) {
                $ok_cat[] = (int) $ncsn;
            } else {
                $power_array = explode(',', $power);
                foreach ($power_array as $gid) {
                    // $gid = (int) $gid;
                    if (in_array($gid, $user_array)) {
                        $ok_cat[] = (int) $ncsn;
                        break;
                    }
                }
            }
        }
        return $ok_cat;
    }
