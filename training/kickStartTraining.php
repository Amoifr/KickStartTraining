<?php

function dd($data)
{
    die(var_dump($data));
}

function dump($data)
{
    var_dump($data);
}


class kickStartTraining
{
    private function getMinimumHoursToInvestByStudentPivot(array $studentSkills, int $numberToPick)
    {
        $minimumHoursToInvestByStudentPivot = [];

        foreach ($studentSkills as $studentIndex => $studentSkill) {
            $studentMinimumHoursToInvest = [];
            foreach ($studentSkills as $comparedStudentIndex => $comparedStudentSkill) {
                if($studentIndex === $comparedStudentIndex) {
                    continue;
                }
                $hoursOfTrainingNeeded = $studentSkill - $comparedStudentSkill;
                if($hoursOfTrainingNeeded >= 0) {
                    $studentMinimumHoursToInvest[] = $hoursOfTrainingNeeded;
                }
            }
            $limitToPick = $numberToPick - 1;
            if(count($studentMinimumHoursToInvest) >= $limitToPick) {
                sort($studentMinimumHoursToInvest);
                $studentMinimumHoursToInvest = array_splice($studentMinimumHoursToInvest, 0, $limitToPick);
                $minimumHoursToInvestByStudentPivot[$studentIndex] = $studentMinimumHoursToInvest;
            }
        }


        return $minimumHoursToInvestByStudentPivot;
    }

    public function solve(int $testCaseIndex, int $numberToPick, array $studentSkills): void
    {
        $minimumHoursToInvestByStudentPivot = $this->getMinimumHoursToInvestByStudentPivot($studentSkills, $numberToPick);
        $minimumHoursToInvest = min(array_map(
            function ($studentDeltas) {
                return array_sum($studentDeltas);
            },
            $minimumHoursToInvestByStudentPivot
        ));

        echo('Case #'. $testCaseIndex .': ' . $minimumHoursToInvest . PHP_EOL);
    }
}





fscanf(STDIN, "%d", $numberOfTestCase);

for ($testCaseIndex = 0; $testCaseIndex < $numberOfTestCase; $testCaseIndex++) {

    fscanf(STDIN, "%d %d", $numberOfStudents, $numberToPick);
    $studentSkills = fgets(STDIN);
    $studentSkills = explode(' ', str_replace(PHP_EOL, '', $studentSkills));
    (new KickStartTraining())->solve($testCaseIndex + 1, $numberToPick, $studentSkills);
}
?>
