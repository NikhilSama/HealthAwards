<?php 
class GraphComponent extends Component
{
     //public $icseMonth = array();    
     public $cbseMonth = array();
     public $icseStudent = array();
     public $cbseStudent = array();
  // bargradex1
    function __construct(ComponentCollection $Collection, $settings = array()) {}
    function bargradex1($noOfUser,$strMonth,$title='',$xaxisTitle="",$yaxisTitle="", $yaxisMaxValue="") {
        
        // Example for use of JpGraph,
        App::import('Vendor',"jpgraph/jpgraph");
        App::import('Vendor',"jpgraph/jpgraph_bar");

        // We need some data
        $datay=$noOfUser;
        $datax=$strMonth;

        // Setup the graph.
        $graph = new Graph(980,400);
        $graph->img->SetMargin(60,20,35,100);
        $graph->SetScale("textlin");
        $graph->SetMarginColor("lightblue:1.1");
        $graph->SetShadow();
		
        // Set up the title for the graph
        $graph->title->Set($title);
        $graph->title->SetMargin(8);
        $graph->title->SetFont(FF_VERDANA,FS_BOLD,12);
        $graph->title->SetColor("darkred");
		
        // Setup font for axis
        $graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,10);
        $graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,10);

        // Show 0 label on Y-axis (default is not to show)
        $graph->yscale->ticks->SupressZeroLabel(false);

        // Setup X-axis labels
		if($xaxisTitle){
			$graph->xaxis->SetTitle($xaxisTitle,"center");
			$graph->xaxis->title->SetFont(FF_VERDANA,FS_BOLD,12);
		}
        $graph->xaxis->SetTickLabels($datax);		
		$graph->xaxis->SetTitleMargin(15);
        $graph->xaxis->SetLabelAngle(40);

        // Create the bar pot
        $bplot = new BarPlot($datay);
		if($yaxisMaxValue!='')
			$bplot->SetYBase($yaxisMaxValue);
		elseif(max($datay)<10)
			$bplot->SetYBase(10);

        $bplot->SetWidth(0.2);
		
        // Setup color for gradient fill style
        //$bplot->SetFillGradient("navy:0.9","navy:1.85",GRAD_LEFT_REFLECTION);


		$bplot->SetFillColor('#75C5F0');
       
        //$bplot3->SetFillColor('darkgreen@0.4');
        

        // Setup each bar with a shadow of 50% transparency
        $bplot->SetShadow('#054C92');
		
		
        // Set color for the frame of each bar
        $bplot->SetColor("white");
        $graph->Add($bplot);

        // Finally send the graph to the browser
        $graph->Stroke();       
    }
   
    function circle($level,$strMonth,$noOfUser_ICSE,$monwisedata) {
       
        App::import('Vendor',"jpgraph/jpgraph");
        App::import('Vendor',"jpgraph/jpgraph_pie");
      
        $data = $level;
        $graph = new PieGraph(700,400);
        // Set A title for the plot
        //$graph->title->Set("Label guide lines");
        $graph->title->SetFont(FF_VERDANA,FS_BOLD,12); 
        $graph->title->SetColor("darkblue");
        $graph->legend->Pos(0.1,0.2);
        // Create pie plot
        $p1 = new PiePlot($data);
        $p1->SetCenter(0.5,0.55);
        $p1->SetSize(0.3);
        // Enable and set policy for guide-lines. Make labels line up vertically
        // and force guide lines to always beeing used
        $p1->SetGuideLines(true,false,true);
        $p1->SetGuideLinesAdjust(1.5);      
        $p1->SetLabels($monwisedata);
        $p1->SetLabelPos(1);
        
        $p1->SetLabelType(PIE_VALUE_PER);    
        $p1->value->Show();            
        $p1->value->SetFont(FF_ARIAL,FS_NORMAL,9);    
        //$p1->value->SetFormat('%2.0f User');        
        // Add and stroke
        $graph->Add($p1);
        $graph->Stroke();
    }
    
    //barlinealphaex1
    function barlinealphaex1($noOfUser,$strMonth) {

        App::import('Vendor',"jpgraph/jpgraph");
        App::import('Vendor',"jpgraph/jpgraph_bar");
        App::import('Vendor',"jpgraph/jpgraph_line");

        // Some "random" data
        $ydata  = $noOfUser;
        $ydata2 = $noOfUser;

        // Get a list of month using the current locale
        $months = $strMonth;//$gDateLocale->GetShortMonth();

        // Create the graph. 
        $graph = new Graph(700,400);    
        $graph->SetScale("textlin");
        $graph->SetMarginColor('white');

        // Adjust the margin slightly so that we use the 
        // entire area (since we don't use a frame)
        $graph->SetMargin(60,1,20,90);

        // Box around plotarea
        $graph->SetBox(); 

        // No frame around the image
        $graph->SetFrame(false);

        // Setup the tab title
        $graph->tabtitle->Set('User Registration By Month');
        $graph->tabtitle->SetFont(FF_ARIAL,FS_BOLD,10);

        // Setup the X and Y grid
        $graph->ygrid->SetFill(true,'#DDDDDD@0.5','#BBBBBB@0.5');
        $graph->ygrid->SetLineStyle('dashed');
        $graph->ygrid->SetColor('gray');
        $graph->xgrid->Show();
        $graph->xgrid->SetLineStyle('dashed');
        $graph->xgrid->SetColor('gray');

        // Setup month as labels on the X-axis
        $graph->xaxis->SetTickLabels($months);
        $graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
        $graph->xaxis->SetLabelAngle(45);

        // Create a bar pot
        $bplot = new BarPlot($ydata);
        $bplot->SetWidth(0.6);
        $fcol='#440000';
        $tcol='#FF9090';

        $bplot->SetFillGradient($fcol,$tcol,GRAD_LEFT_REFLECTION);

        // Set line weigth to 0 so that there are no border
        // around each bar
        $bplot->SetWeight(0);

        $graph->Add($bplot);

        // Create filled line plot
        $lplot = new LinePlot($ydata2);
        $lplot->SetFillColor('skyblue@0.5');
        $lplot->SetColor('navy@0.7');
        $lplot->SetBarCenter();

        $lplot->mark->SetType(MARK_SQUARE);
        $lplot->mark->SetColor('blue@0.5');
        $lplot->mark->SetFillColor('lightblue');
        $lplot->mark->SetSize(6);

        $graph->Add($lplot);

        // .. and finally send it back to the browser
        $graph->Stroke();
    }
    
    function centeredlineex03($noOfUser,$strMonth) {
        App::import('Vendor',"jpgraph/jpgraph");
        App::import('Vendor',"jpgraph/jpgraph_line");

        $labels = $strMonth;
        $datay = $noOfUser;
        $graph = new Graph(700,400);
        $graph->img->SetMargin(40,40,40,80);    
        $graph->img->SetAntiAliasing();
        $graph->SetScale("textlin");
        $graph->SetShadow();
        $graph->title->Set("User Registration By Month");
        $graph->title->SetFont(FF_VERDANA,FS_NORMAL,14);

        $graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,11);
        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetLabelAngle(45);

        $p1 = new LinePlot($datay);
        $p1->mark->SetType(MARK_FILLEDCIRCLE);
        $p1->mark->SetFillColor("red");
        $p1->mark->SetWidth(4);
        $p1->SetColor("blue");
        $p1->SetCenter();
        $graph->Add($p1);

        $graph->Stroke();
    }
    
   function alphabarex1($marks,$qNo,$marksObtain) {
  
        App::import('Vendor',"jpgraph/jpgraph");
        App::import('Vendor',"jpgraph/jpgraph_bar");
        
        // Some data
        $datay1=$marks;
        $datay2=$marksObtain;
        $gWidth = 700;
        $gHeight = 300;
  
        $graph = new Graph($gWidth,$gHeight);
        
        
        $graph->img->SetMargin(50,20,40,50);
        $graph->SetScale("textlin");
        //$graph->img->SetMargin(40,80,30,40);

        // Adjust the position of the legend box
        $graph->legend->Pos(0.02,0.0);

        // Adjust the color for theshadow of the legend
        $graph->legend->SetShadow('darkgray@0.5');
        $graph->legend->SetFillColor('lightblue@0.3');

        // Get localised version of the month names
        $graph->xaxis->SetTickLabels($qNo);

        // Set a nice summer (in Stockholm) image
       // $graph->SetBackgroundImage('../../app/vendors/jpgraph/Examples/lightbluedarkblue400x300grad.png');

        // Set axis titles and fonts
        //$graph->xaxis->title->Set('Year 2002');
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetColor('white');

        $graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->SetColor('white');

        $graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
        $graph->yaxis->SetColor('white');
        
        
        //$graph->ygrid->Show(false);
        $graph->ygrid->SetColor('white@0.5');

        // Setup graph title
        $graph->title->Set('Question-wise Report');
        // Some extra margin (from the top)
        $graph->title->SetMargin(3);
        $graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);

        // Create the three var series we will combine
        $bplot1 = new BarPlot($datay1);
        $bplot2 = new BarPlot($datay2);
        //$bplot3 = new BarPlot($datay3);

        // Setup the colors with 40% transparency (alpha channel)
        $bplot1->SetFillColor('#75C5F0');
        $bplot2->SetFillColor('#DEDEDD');
        //$bplot3->SetFillColor('darkgreen@0.4');
        
        // Setup legends
        $bplot1->SetLegend('Marks Obtained');
        $bplot2->SetLegend('Maximum Marks');
        //$bplot3->SetLegend('Label 3');

        // Setup each bar with a shadow of 50% transparency
        $bplot1->SetShadow('#054C92');
        $bplot2->SetShadow('#72706F');
        //$bplot3->SetShadow('black@0.4');

        $gbarplot = new GroupBarPlot(array($bplot1,$bplot2));
        $gbarplot->SetWidth(0.6);
        $graph->Add($gbarplot);

        $graph->Stroke();
    }
    
     function chapterWise($marks,$qNo,$marksObtain,$averageMarks) {
  
        App::import('Vendor',"jpgraph/jpgraph");
        App::import('Vendor',"jpgraph/jpgraph_bar");
        
        // Some data
        $datay1=$marks;
        $datay2=$marksObtain;
        $datay3 = $averageMarks;
        
        $gWidth = 700;
        $gHeight = 300;
  
        $graph = new Graph($gWidth,$gHeight);
        
        
        $graph->img->SetMargin(50,20,60,50);
        $graph->SetScale("textlin");
        //$graph->img->SetMargin(40,80,30,40);

        // Adjust the position of the legend box
        $graph->legend->Pos(0.02,0.0);

        // Adjust the color for theshadow of the legend
        $graph->legend->SetShadow('darkgray@0.5');
        $graph->legend->SetFillColor('lightblue@0.3');

        // Get localised version of the month names
        $graph->xaxis->SetTickLabels($qNo);

        // Set a nice summer (in Stockholm) image
       // $graph->SetBackgroundImage('../../app/vendors/jpgraph/Examples/lightbluedarkblue400x300grad.png');

        // Set axis titles and fonts
        //$graph->xaxis->title->Set('Year 2002');
        $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->title->SetColor('white');

        $graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
        $graph->xaxis->SetColor('white');

        $graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
        $graph->yaxis->SetColor('white');
        
        
        $graph->ygrid->Show(true);
        $graph->ygrid->SetColor('gray');

        // Setup graph title
        $graph->title->Set('Question-wise Report');
        // Some extra margin (from the top)
        $graph->title->SetMargin(10);
        $graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);

        // Create the three var series we will combine
        $bplot1 = new BarPlot($datay1);
        $bplot2 = new BarPlot($datay2);
        $bplot3 = new BarPlot($datay3);
        //$bplot3 = new BarPlot($datay3);

        // Setup the colors with 40% transparency (alpha channel)
        $bplot1->SetFillColor('#75C5F0');
        $bplot2->SetFillColor('#DEDEDD');
        $bplot3->SetFillColor('#FFD3AF');
        //$bplot3->SetFillColor('darkgreen@0.4');
        
        // Setup legends
        $bplot1->SetLegend('Marks Obtained');
        $bplot2->SetLegend('Maximum Marks');
        $bplot3->SetLegend('Avreage Marks');
        //$bplot3->SetLegend('Label 3');

        // Setup each bar with a shadow of 50% transparency
        $bplot1->SetShadow('#054C92');
        $bplot2->SetShadow('#72706F');
        $bplot3->SetShadow('#CFC5B5');
        //$bplot3->SetShadow('black@0.4');

        $gbarplot = new GroupBarPlot(array($bplot1,$bplot3,$bplot2));
        $gbarplot->SetWidth(0.6);
        $graph->Add($gbarplot);

        $graph->Stroke();
    }
  }
?>