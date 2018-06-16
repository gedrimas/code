<?php


include_once '../config/constants.php';
include_once '../classes/connect_db.php';
include_once '../PHPExcel/Classes/PHPExcel.php';
include_once '../config/prices_config.php';

$Db = Db_connection::getInstance(HOST, USER, PASSWORD, DATABASE, CHARSET);
$linkCon = $Db::$linkCon;


    
class MyReadFilter implements PHPExcel_Reader_IReadFilter
{  
    private $mas_columns;
    
    public function __construct($mas_columns) 
    {
        $this->mas_columns = $mas_columns;
    }

    public function readCell($column, $row, $worksheetName = '') 
    {
        if (in_array($column, $this->mas_columns)) return true;
        return false;
    }
}

class ImportExel
{
    public $inputFileType = 'Excel2007';
    public $inputFileName;
    public $mas_columns;
    public $mas_ind_columns;
    public $row_start;
    public $sheet_list;
    public $objReader;
    public $parse_reg;
        
    public function __construct($inputFileName, $mas_columns, $mas_ind_columns, $row_start, $sheet_list, $parse_reg) 
    {
        $this->inputFileName = $inputFileName;
        $this->mas_columns = $mas_columns;
        $this->mas_ind_columns = $mas_ind_columns;
        $this->row_start = $row_start;
        $this->sheet_list = $sheet_list;
        $this->parse_reg = $parse_reg;           
    }

    public function get_xls_data()
    {
        $this->objReader = PHPExcel_IOFactory::createReader($this->inputFileType);
        $this->objReader->setLoadSheetsOnly($this->sheet_list);
        $this->objReader->setReadDataOnly(true);
        $this->objReader->setReadFilter( new MyReadFilter($this->mas_columns) );
        $objPHPExcel = $this->objReader->load($this->inputFileName);
        $objWorksheet = $objPHPExcel->getSheetByName($this->sheet_list);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        
        $mas_vcell = array();
        $row = $this->row_start;
        for ($row; $row <= $highestRow; ++$row) 
        {
            
            $mas_vcell_tmp = array();
            for ($col = 0; $col <= $highestColumnIndex; ++$col) 
            {
                if(in_array($col, $this->mas_ind_columns))
                {
                    $vcell = $objWorksheet->getCellByColumnAndRow($col , $row)->getValue();
                    $vcell = trim($vcell);
                    
                     if(empty($vcell) || $row < $this->row_start)
                    {
                        $mas_vcell_tmp = array();
                        break;
                    }
                    if(!empty($vcell))
                    {
                        $mas_vcell_tmp[] = iconv('utf-8', 'cp1251', $vcell);
                    }
                                     
                }
            }
            if(count($mas_vcell_tmp) > 0)
            {
                $mas_vcell[] = $mas_vcell_tmp;
            }
        }
        return $mas_vcell;
       
    }
      
    public function fill_tables($linkCon, $mas_vcell, $regexp, $table){
        
        mysql_query("TRUNCATE TABLE ".$table, $linkCon);
        
        foreach ($mas_vcell as $row){
            if(preg_match($regexp, $row[1], $matches))
            {
                array_shift($matches);
                $arr_data = array_merge($matches, $row);
                //print_r($arr_data);
                //echo "<br />";
                $arr_data_all[] = $arr_data;
            }           
        }
        
        
        foreach ($arr_data_all as $row) {            
            
            foreach ($row as $feacher){
                
                $feacher = "'".$feacher."'";
                $row_feacher[] = $feacher;
                
                    if (count($row_feacher) == count($row)){          
                    $data_to_db = implode(',',$row_feacher);
                    $row_feacher = array();
                    $insert = "INSERT INTO ".$table." VALUES(".$data_to_db.")";
                    mysql_query($insert);
                    print_r(mysql_error());
                    }
            }            
        }           
    }
}


$iek_to_db = new ImportExel(
                    $config_prices ['IEK']['inputFileName'],$config_prices ['IEK']['mas_columns'],
                    $config_prices ['IEK']['mas_ind_columns'], $config_prices ['IEK']['row_start'],
                    $config_prices ['IEK']['sheet_list'], $config_prices ['IEK']['parse_reg'],
                    $config_prices['IEK']['table_name']                 
        );
$mas_vcell = $iek_to_db->get_xls_data();
for($i = 0; $i < 7; $i++)
    {
        $iek_to_db->fill_tables($linkCon, $mas_vcell, $config_prices ['IEK']['parse_reg'][$i], $config_prices['IEK']['table_name'][$i]);
    }
 

$sh_to_db = new ImportExel($config_prices ['SH']['inputFileName'],$config_prices ['SH']['mas_columns'],
                    $config_prices ['SH']['mas_ind_columns'], $config_prices ['SH']['row_start'],
                    $config_prices ['SH']['sheet_list'], $config_prices ['SH']['parse_reg'],
                    $config_prices['SH']['table_name']                 
        );
$mas_vcell = $sh_to_db->get_xls_data();
for($i = 0; $i < 3; $i++)
    {
        $sh_to_db->fill_tables($linkCon, $mas_vcell, $config_prices ['SH']['parse_reg'][$i], $config_prices['SH']['table_name'][$i]);
    }