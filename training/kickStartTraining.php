<?php
/****************************************************************************
 * Class to solve the kick start training problem
 ***************************************************************************/
class kickStartTraining
{

    private function getMinimumHoursToInvestByStudentPivot(array $studentSkills, int $numberToPick)
    {
        $minimumHoursToInvestByStudentPivot = [];

        /**for each student evaluate the minimum hours to invest*/
        foreach ($studentSkills as $studentIndex => $studentSkill) {
            $studentMinimumHoursToInvest = [];
            foreach ($studentSkills as $comparedStudentIndex => $comparedStudentSkill) {
                if($studentIndex === $comparedStudentIndex) {
                    continue;
                }
                $numberOfHoursOfTrainingNeeded = $studentSkill - $comparedStudentSkill;
                /** If the number of hours of training needed is negative, then the student doesn't need to improve his skills */
                if($numberOfHoursOfTrainingNeeded >= 0) {
                    $studentMinimumHoursToInvest[] = $numberOfHoursOfTrainingNeeded;
                }
            }
            /** number of students to pick except current student */
            $limitToPick = $numberToPick - 1;
            /** Do we get enough student above whom improve his skill, if too many remove he lowest skilled */
            if(count($studentMinimumHoursToInvest) >= $limitToPick) {
                sort($studentMinimumHoursToInvest);
                $studentMinimumHoursToInvest = array_splice($studentMinimumHoursToInvest, 0, $limitToPick);
            }
            $minimumHoursToInvestByStudentPivot[$studentIndex] = $studentMinimumHoursToInvest;
        }


        return $minimumHoursToInvestByStudentPivot;
    }

    public function solve(int $testCaseIndex, int $numberToPick, array $studentSkills): void
    {
        $minimumHoursToInvestByStudentPivot = $this->getMinimumHoursToInvestByStudentPivot($studentSkills, $numberToPick);
        /** get the minimal time to invest from eligible student as pivot */
        $minimumHoursToInvest = min(array_map(
            function ($studentDeltas) {
                return array_sum($studentDeltas);
            },
            $minimumHoursToInvestByStudentPivot
        ));

        echo('Case #'. $testCaseIndex .': ' . $minimumHoursToInvest . PHP_EOL);
    }

    /** only for local debugging purpose */
/*
    function dd($data)
    {
        die(var_dump($data));
    }

    function dump($data)
    {
        var_dump($data);
    }
*/

}

/**********************************************************************************************
 *  Mandatory code to get sample and test data
 *********************************************************************************************/
fscanf(STDIN, "%d", $numberOfTestCase);
for ($testCaseIndex = 0; $testCaseIndex < $numberOfTestCase; $testCaseIndex++) {
    fscanf(STDIN, "%d %d", $numberOfStudents, $numberToPick);
    $studentSkills = fgets(STDIN);
    $studentSkills = explode(' ', str_replace(PHP_EOL, '', $studentSkills));
    (new KickStartTraining())->solve($testCaseIndex + 1, $numberToPick, $studentSkills);
}
?>
