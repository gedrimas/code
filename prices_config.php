<?php


$config_prices = array(
                        'IEK' => array(
                            'inputFileName' => 'C:\OpenServer\domains\cb137\iek\iek_price.xlsx',
                            'row_start' => '13',
                            'mas_columns' => array('A','B','I'),
                            'mas_ind_columns' => array('0','1','8'),
                            'sheet_list' => 'price',
                            'table_name' => array('iek_va', 'iek_uzo', 'iek_uzo_type_a', 'iek_ad', 'iek_adm', 'iek_avdt', 'iek_avdtm'),
                            'fields_name' => array('type', 'current', 'pole', 'feacher', 'break_cap', 'art', 'name', 'cost', 'type_uzo', 'diff_current' ),
                            'parse_reg' => array(
                                '/([A-Z?-?]+?\s*47-\d{2,3}[A-Z?-?]*)\s+(\d).+?\s*(\d*).+?(\d\,*\d*).+\s([A-Z?-?])\s/',
                                '/([A-Z?-?]+1-63[A-Z?-?]*)\s*(\d)[A-Za-z?-??-?]\s*(\d+)[A-Z?-??-?]\s*(\d+)[A-Za-z?-??-?]+\s???/',
                                '/([A-Z?-?]+1-63[A-Z?-?]*)\s*(\d)[A-Za-z?-??-?]\s*(\d+)[A-Z?-??-?]\s*(\d+)[A-Za-z?-??-?]+\s+([a-z?-?]*\s[A-Z?-?])\s/',
                                '/([??]+\d+)\s*(\d+).\s(\d+)[A-Z?-?]*\s+(\d+)/',
                                '/(??\d*[A-Z?-?])\s*(\d*).\s([A-Z?-?])(\d+)\s+(\d+)/',
                                '/(????)\s?(\d+)\s([A-Z?-?])(\d+)\s(\d*)/',
                                '/(????)(\d+).?\s([A-Z?-?])(\d+)\s(\d*)/'
                                ),
                            'skip' => false
                        ),
                        'SH' => array(
                            'inputFileName' => 'C:\OpenServer\domains\cb137\iek\Schneider_Electric.xlsx',
                            'row_start' => '4',
                            'mas_columns' => array('A','B','C'),
                            'mas_ind_columns' => array('0','1','2'),
                            'sheet_list' => 'absd',
                            'table_name' => array('sh_ic60','sh_120125'),
                            'fields_name' => array('type', 'pole', 'current', 'feacher', 'art', 'name', 'cost'),
                            'parse_reg' => array(
                                '/\.(i[KC]60[NHL]*)\s(\d).\s(\d+|0,5|1,6).\s+(.)/',
                                '/\.\s(C120[NH]|NG125[NHL])\s(\d).\s(\d+).\s(.)/'
                                ),
                            'skip' => false                            
                        ),
    
                             'ABB' => array(
                            'inputFileName' => 'Z:\home\estimate\www\cron\files\ABB.xlsx',
                            'col' => -1,
                            'mas_columns' => array('A','C','F','K'),
                            'mas_ind_columns' => array('0','2','5', '10'),
                            'sheet_list' => array('������������� ������������'),
                            'table_name' => 'pr_abb',
                             'fields_name' => array('iek_art', 'iek_name', 'iek_cost'),
                            'skip' => true
                        ),
                        'keaz' => array(
                            'inputFileName' => 'Z:\home\estimate\www\cron\files\keaz.xlsx',
                            'col' => -1,
                            'mas_columns' => array('A','B','E'),
                            'mas_ind_columns' => array('0','1','4'),
                            'sheet_list' => array('�����-����'),
                            'table_name' => 'pr_keaz',
                            'fields_name' => array('iek_art', 'iek_name', 'iek_cost'),
                            'skip' => false
                        )
                       );

   
     

?>