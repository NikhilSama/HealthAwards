<?php 
class FilepathComponent extends Component
{	public $uses = array('Chapter');
    
    function __construct(ComponentCollection $Collection, $settings = array()) {}
    
   function fatLpVideoPath($filename=null) {
	   if($filename!=null) {
		   $videoArray = explode("-",substr($filename,0,-4));
		   $lpVideoPath = str_replace('videos','lp_videos',str_replace('_','/',str_replace('video','_img_videos',$videoArray[0]))).'/';

		   return $lpVideoPath;
	   }else{
		   return false;
	   }
   }

   function currPuzzlePath($filename=null) {
	   $puzzleArray = explode("-",substr($filename,0,-4));
	   if($filename!=null) {
		   $puzzlePath = '/img/puzzles/'.$puzzleArray[1].'/'.$puzzleArray[2].'/'.$puzzleArray[3].'/'.$puzzleArray[4].'/';
		   return $puzzlePath;
	   }else{
		   return false;
	   }
   }
   
   function currPuzzleThumbnailPath($filename=null) {
	   $thumbPuzzleArray = explode("-",substr($filename,0,-4));
	   if($filename!=null) {
		   $thumbPuzzlePath = '/img/puzzles/'.$thumbPuzzleArray[1].'/'.$thumbPuzzleArray[2].'/'.$thumbPuzzleArray[3].'/'.$thumbPuzzleArray[4].'/';
			return $thumbPuzzlePath;
		}else{
			return false;
		}
   }

   function currQuestionPathSql($chapterId=null) {
	   if($chapterId!=null) {
		   $sql = mysql_query("select Grade.id as gradeId,Subject.id as subjectId,Chapter.chapterNo from chapters Chapter,textbooks gsm,grades Grade,subjects Subject where Chapter.textbookId=gsm.id and gsm.gradeId=Grade.id and gsm.subjectId=Subject.id and Chapter.id='".$chapterId."'");
		   $fetchdir = mysql_fetch_assoc($sql);
		   $gradeId =  $fetchdir['gradeId'];
		   $subjectId =  $fetchdir['subjectId'];
		   $chapterNo =  $fetchdir['chapterNo'];
		   $questionPath = '/img/ncertsolutions/'.$gradeId.'/'.$subjectId.'/'.$chapterNo.'/';
		   return $questionPath;
	   }else{
		   return false;
	   }
   }
}
?>