<?php
//Model基類
class Model extends DB
{
    protected $_db     = null;
    protected $_fields = array();
    protected $_tables = array();
    protected $_check  = null;
    protected $_limit  = '';
    protected $_R      = array();
    protected function __construct()
    {
        $this->_db = parent::getInstance();
    }

    protected function getRequest()
    {
        return Request::getInstance($this, $this->_check);
    }

    protected function getSort($_col, $_param = array())
    {
        return $this->_db->getMaxSort($this->_tables, $_col, $_param);
    }

    protected function total(array $_param = array())
    {
        return $this->_db->totalNum($this->_tables, $_param);
    }

    protected function delete(array $_param)
    {
        return $this->_db->deleteData($this->_tables, $_param);
    }

    protected function select(array $_field, array $_param = array())
    {
        return $this->_db->selectData($this->_tables, $_field, $_param);
    }

    protected function add(array $_addData)
    {
        return $this->_db->addData($this->_tables, $_addData);
    }

    protected function update(array $_param, array $_updateData)
    {
        return $this->_db->updateData($this->_tables, $_param, $_updateData);
    }

    public function isOne(array $_param)
    {
        return $this->_db->isOneData($this->_tables, $_param);
    }

    //不需連數據庫
    public function setLimit($_limit)
    {
        $this->_limit = $_limit;
    }
}
