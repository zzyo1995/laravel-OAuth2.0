<?php
/*
	use PHPExcel; 
	use PHPExcel_IOFactory;
    public function excel() {

        $data = $this->getExamInfo();

        // 所教学科id
        $subject = D('Exam')->getTeacherInfo($this->authInfo);
        $list = M('Score')->where(array('acp_id' => intval($_GET['id'])))->order('sc_rank ASC')->select();
        $auth = getDataByArray('Auth', $list, 'a_id', 'a_id,a_nickname');

        foreach ($list as &$value) {
            $value['a_nickname'] = $auth[$value['a_id']]['a_nickname'];
        }

        import('@.ORG.PHPExcel.PHPExcel');

        // Create new PHPExcel object  
        $objPHPExcel = new PHPExcel();
        // Set properties  
        $objPHPExcel->getProperties()->setCreator("ctos")
                ->setLastModifiedBy("ctos")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

        // set width  
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

        // 设置行高度  
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        // 字体和样式
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

        // 设置水平居中  
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //  合并
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');

        // 表头
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $data['examTitle'])
                ->setCellValue('A2', '序号')
                ->setCellValue('B2', '姓名')
                ->setCellValue('C2', '班级')
                ->setCellValue('D2', '成绩');

        // 内容
        for ($i = 0, $len = count($list); $i < $len; $i++) {
            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($i + 3), $list[$i]['sc_rank']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($i + 3), $list[$i]['a_nickname']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($i + 3), $data['title']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($i + 3), $list[$i]['sc_point']);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3) . ':D' . ($i + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($i + 3) . ':D' . ($i + 3))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getRowDimension($i + 3)->setRowHeight(16);
        }

        // Rename sheet  
        $objPHPExcel->getActiveSheet()->setTitle($data['examTitle']);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
        $objPHPExcel->setActiveSheetIndex(0);

        // 输出
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $data['examTitle'] . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }*/
