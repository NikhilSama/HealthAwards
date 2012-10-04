<?php 

class GradecalculaterComponent extends Component
{
    function __construct() {}
	public function getGrade($marksPercentage,$withGradePoint=0){
		$marksPercentage = round($marksPercentage);
		if($marksPercentage>=91 && $marksPercentage<=100){
			$grade = "A1";
			$point = 10;			
		}elseif($marksPercentage>=81 && $marksPercentage<=90){
			$grade = "A2";
			$point = 9.0;			
		}elseif($marksPercentage>=71 && $marksPercentage<=80){
			$grade = "B1";
			$point = 8.0;
		}elseif($marksPercentage>=61 && $marksPercentage<=70){
			$grade = "B2";
			$point = 7.0;
		}elseif($marksPercentage>=51 && $marksPercentage<=60){
			$grade = "C1";
			$point = 6.0;
		}elseif($marksPercentage>=41 && $marksPercentage<=50){
			$grade = "C2";
			$point = 5.0;
		}elseif($marksPercentage>=33 && $marksPercentage<=40){
			$grade = "D";
			$point = 4.0;
		}elseif($marksPercentage>=21 && $marksPercentage<=32){
			$grade = "E1";
			$point = "";
		}else{
			$grade = "E2";
			$point = "";
		}
		if($withGradePoint){
			return array($grade, $point);
		}else{
			return $grade;
		}
	}
	public function getRawScore($marks) {
		$rawScores = array();
		$a1_2 = $marks;
		for($i=100;$i>0;$i=$i-10){
			$rawScores['A1']['rawScore'] = round(91*$marks/100).' to '.round(91*$marks/100); // 91% to 100%
			$rawScores['A1']['pecentScore'] = '91% to 100%'; // 91% to 100%
			$rawScores['A1']['gradePoint'] = '10.0';
			$rawScores['A1']['frequency'] = 0;
		}
		$a1_1 = round(91*$marks/100); // 91%
		$a2_2 = round(90*$marks/100); // 90%
		$a2_1 = round(81*$marks/100); // 81%
		$a3_2 = round(80*$marks/100); // 80%
		$a3_1 = round(71*$marks/100); // 71%
		$a4_2 = round(70*$marks/100); // 70%
		$a4_1 = round(61*$marks/100); // 61%
		$a5_2 = round(60*$marks/100); // 60%
		$a5_1 = round(51*$marks/100); // 51%
		$a6_2 = round(50*$marks/100); // 50%
		$a6_1 = round(41*$marks/100); // 41%
		$a7_2 = round(40*$marks/100); // 40%
		$a7_1 = round(33*$marks/100); // 33%
		$a8_2 = round(32*$marks/100); // 32%
		$a8_1 = round(21*$marks/100); // 21%
		$a9_2 = round(20*$marks/100); // 20%
		$a9_1 = 0; // 0%
		
		$rawScores['A1']['rawScore'] = $a1_1.' to '.$a1_2; // 91% to 100%
		$rawScores['A1']['pecentScore'] = '91% to 100%'; // 91% to 100%
		$rawScores['A1']['gradePoint'] = '10.0';
		$rawScores['A1']['frequency'] = 0;

		$rawScores['A2']['rawScore'] = $a2_1.' to '.$a2_2; // 81% to 90%
		$rawScores['A2']['pecentScore'] = '81% to 90%'; // 81% to 90%
		$rawScores['A2']['gradePoint'] = '9.0';
		$rawScores['A2']['frequency'] = 0;

		$rawScores['B1']['rawScore'] = $a3_1.' to '.$a3_2; // 71% to 80%
		$rawScores['B1']['pecentScore'] = '71% to 80%'; // 71% to 80%
		$rawScores['B1']['gradePoint'] = '8.0';
		$rawScores['B1']['frequency'] = 0;

		$rawScores['B2']['rawScore'] = $a4_1.' to '.$a4_2; // 61% to 70%
		$rawScores['B2']['pecentScore'] = '61% to 70%'; // 61% to 70%
		$rawScores['B2']['gradePoint'] = '7.0';
		$rawScores['B2']['frequency'] = 0;

		$rawScores['C1']['rawScore'] = $a5_1.' to '.$a5_2; // 51% to 60%
		$rawScores['C1']['pecentScore'] = '51% to 60%'; // 51% to 60%
		$rawScores['C1']['gradePoint'] = '6.0';
		$rawScores['C1']['frequency'] = 0;

		$rawScores['C2']['rawScore'] = $a6_1.' to '.$a6_2; // 41% to 50%
		$rawScores['C2']['pecentScore'] = '41% to 50%'; // 41% to 50%
		$rawScores['C2']['gradePoint'] = '5.0';
		$rawScores['C2']['frequency'] = 0;

		$rawScores['D']['rawScore'] = $a7_1.' to '.$a7_2; // 33% to 40%
		$rawScores['D']['pecentScore'] = '33% to 40%'; // 33% to 40%
		$rawScores['D']['gradePoint'] = '4.0';
		$rawScores['D']['frequency'] = 0;

		$rawScores['E1']['rawScore'] = $a8_1.' to '.$a8_2; // 21% to 32%
		$rawScores['E1']['pecentScore'] = '21% to 32%'; // 21% to 32%
		$rawScores['E1']['gradePoint'] = '-';
		$rawScores['E1']['frequency'] = 0;

		$rawScores['E2']['rawScore'] = $a9_1.' to '.$a9_2; // 0% to 20%
		$rawScores['E2']['pecentScore'] = '20% or Less'; // 0% to 20%
		$rawScores['E2']['gradePoint'] = '-';
		$rawScores['E2']['frequency'] = 0;

		return $rawScores;
	}

}