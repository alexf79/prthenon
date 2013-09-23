
<div class="cat-list">
    <h3>Profile Questions</h3>  
    <div class='cat-sublist'>
    <?php
    //Profile Question/Answer Code
    $answer_array = array();
	if($_SESSION['view_user']['answers'] != '')
	{		
		$a_list = explode("*-*",$_SESSION['view_user']['answers']);
		foreach($a_list as $qa)
		{
			$qa_array = explode(":",$qa);
			$question = $qa_array[0];
			$answer = $qa_array[1];
			$answer_array[$question] = $answer;
		}
	}
	$q_list = '';
    
    $q_sql = "SELECT pn_questions.id as qID, pn_questions.question as question FROM pn_questions WHERE pn_questions.question != '' ORDER BY pn_questions.id ASC";
    $q_qry = mysql_query($q_sql, $connect)or die(mysql_error());	
    
    $num_qs = mysql_num_rows($q_qry);    
    if($num_qs > 0)
    {
        $q=1;
        while($q_res = mysql_fetch_array($q_qry))
        {				
            $qid = $q_res['qID'];
            $question = $q_res['question'];
            $q_list .= $qid." ";
			if(array_key_exists($qid,$answer_array))
			{
				$a_value = $answer_array[$qid];
			}
            ?>
            <div class='question'>
            Q: <?php echo $question;?><br />
            A: <?php echo $a_value;?><br /><br />
            </div>
            <?php
            unset($question,$qid);
            $q++;
        }
    }   
    ?>
    </div>
</div>       