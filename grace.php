<?php
session_start();
include('config.php');

// Assuming you have retrieved the student's roll number from the website
$rollNumber = $_POST['roll_number'];

// Retrieve the student's grace marks
$sql = "SELECT Gracemarks FROM  marks WHERE roll_number = '$rollNumber'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $graceMarks = $row['Gracemarks'];

    // Check if the student has failed in any subjects
    $sql = "SELECT dsa, popl, os, ml, fods, se FROM marks WHERE roll_number = '$rollNumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $dsa = $row['dsa'];
        $popl = $row['popl'];
        $os = $row['os'];
        $ml = $row['ml'];
        $fods = $row['fods'];
        $se = $row['se'];

        $failedSubjects = [];
        $gradeImprovedSubjects = [];
        $subject1Req = calculateReqMark($dsa);
        $subject2Req = calculateReqMark($popl);
        $subject3Req = calculateReqMark($os);
        $subject4Req = calculateReqMark($ml);
        $subject5Req = calculateReqMark($fods);
        $subject6Req = calculateReqMark($se);

        $subject1Grad = calculateGrade($dsa);
        $subject2Grad = calculateGrade($popl);
        $subject3Grad = calculateGrade($os);
        $subject4Grad = calculateGrade($ml);
        $subject5Grad = calculateGrade($fods);
        $subject6Grad = calculateGrade($se);

        if ($dsa < 35) {
            $failedSubjects['dsa'] = ['requiredMarks' => 35 - $dsa, 'credits' => getSubjectCredits('dsa')];
        } else {
            $gradeImprovedSubjects['dsa'] = ['requiredMarks' => $subject1Req, 'credits' => getSubjectCredits('dsa')];
        }
        if ($popl < 35) {
            $failedSubjects['popl'] = ['requiredMarks' => 35 - $popl, 'credits' => getSubjectCredits('popl')];
        } else {
            $gradeImprovedSubjects['popl'] = ['requiredMarks' => $subject2Req, 'credits' => getSubjectCredits('popl')];
        }
        if ($os < 35) {
            $failedSubjects['os'] = ['requiredMarks' => 35 - $os, 'credits' => getSubjectCredits('os')];
        } else {
            $gradeImprovedSubjects['os'] = ['requiredMarks' => $subject3Req, 'credits' => getSubjectCredits('os')];
        }
        if ($ml < 35) {
            $failedSubjects['ml'] = ['requiredMarks' => 35 - $ml, 'credits' => getSubjectCredits('ml')];
        } else {
            $gradeImprovedSubjects['ml'] = ['requiredMarks' => $subject4Req, 'credits' => getSubjectCredits('ml')];
        }
        if ($fods < 35) {
            $failedSubjects['fods'] = ['requiredMarks' => 35 - $fods, 'credits' => getSubjectCredits('fods')];
        } else {
            $gradeImprovedSubjects['fods'] = ['requiredMarks' => $subject5Req, 'credits' => getSubjectCredits('fods')];
        }
        if ($se < 35) {
            $failedSubjects['se'] = ['requiredMarks' => 35 - $se, 'credits' => getSubjectCredits('se')];
        } else {
            $gradeImprovedSubjects['se'] = ['requiredMarks' => $subject6Req, 'credits' => getSubjectCredits('se')];
        }
        // Sort the failed subjects in ascending order of required marks and with high credits
        uasort($failedSubjects, function ($a, $b) {
            $marksComparison = $a['requiredMarks'] - $b['requiredMarks'];

            if ($marksComparison === 0) {
                return $b['credits'] - $a['credits'];
            }

            return $marksComparison;
        });

        // Print subjects with the same required marks and choose the highest credit subject
        $subjectsWithSameMarks = [];
        $highestCreditSubject = null;
        $highestCredit = 0;

        foreach ($failedSubjects as $subject => $details) {
            $marks = $details['requiredMarks'];
            $subjectsWithSameMarks[$marks][] = $subject;

            if ($details['credits'] > $highestCredit) {
                $highestCredit = $details['credits'];
                $highestCreditSubject = $subject;
            }
        }

        foreach ($subjectsWithSameMarks as $marks => $subjects) {
            if (count($subjects) > 1) {
                $message = "Subjects with required marks $marks: " . implode(', ', $subjects) . "<br>";
                $message .= "Choosing the subject with the highest credit for grace marks: $highestCreditSubject<br>";
                $_SESSION['messages'][] = $message;
            }
        }
        $failedcount=count($failedSubjects);
        $count=0;

        // Distribute the grace marks to the subjects starting from the one with the fewest required marks
        foreach ($failedSubjects as $subject => $details) {
            $requiredMarks = $details['requiredMarks'];

            if ($graceMarks > 0) {
                $additionalMarks = min($graceMarks, $requiredMarks);

                if ($additionalMarks > 0) {
                    $newMarks = $row[$subject] + $additionalMarks;

                    // Check if adding the additional marks will result in passing
                    if ($newMarks >= 35) {
                        $newMarks = 35; // Set the marks to the passing minimum of 35
                        $message = "Grace marks added successfully for $subject<br>";
                        $message .= "Passed in $subject<br>";
                        $_SESSION['messages'][] = $message;

                        $graceMarks -= $additionalMarks;
                        $requiredMarks -= $additionalMarks;

                        $sql = "UPDATE marks SET $subject = $newMarks WHERE roll_number = '$rollNumber'";
                        $conn->query($sql);
                    } else {
                        $message = "Grace marks are not sufficient to pass $subject<br>";
                        $_SESSION['messages'][] = $message;
                        $count+=1;
                    }
                }
            }
        }
        if($count>0){
            $leastSubject = null;
            $leastMarks = PHP_INT_MAX;
            foreach ($failedSubjects as $subject => $details) {
                if ($row[$subject] < $leastMarks) {
                    $leastSubject = $subject;
                    $leastMarks = $row[$subject];
                }
            }
            $message = "Remaining Grace Marks Added In Least Scoring Subject: $leastSubject";
            $_SESSION['messages'][] = $message;
            $newMarks=$row[$leastSubject]+$graceMarks;
            $sql = "UPDATE marks SET $leastSubject = $newMarks WHERE roll_number = '$rollNumber'";
            $conn->query($sql);

        }
        $count2=0;
        if (empty($failedSubjects)) {
            $message = "No failed subjects<br>";
            $_SESSION['messages'][] = $message;
            foreach ($gradeImprovedSubjects as $subject => $details) {
                $requiredMarks = $details['requiredMarks'];

                if ($graceMarks > 0) {
                    $additionalMarks = min($graceMarks, $requiredMarks);

                    if ($additionalMarks > 0) {
                        $newMarks = $row[$subject] + $additionalMarks;
                        $oldGrade = calculateGrade($row[$subject]);
                        $newGrade = calculateGrade($newMarks);
                        // Check if adding the additional marks will result in passing
                        if ($newGrade > $oldGrade) {
                            $message = "Grace marks added successfully for $subject<br>";
                            $message .= "Grade in $subject improved from $oldGrade to $newGrade<br>";
                            $_SESSION['messages'][] = $message;
                            $graceMarks -= $additionalMarks;
                            $requiredMarks -= $additionalMarks;

                            $sql = "UPDATE marks SET $subject = $newMarks WHERE roll_number = '$rollNumber'";
                            $conn->query($sql);

                        } else {
                            $message = "Grace marks are not sufficient to improve the grade in $subject <br>";
                            $_SESSION['messages'][] = $message;
                            $count2+=1;
                        }
                    }
                }
            }   
        }
        if ($graceMarks > 0 && $count2 > 0) {
            $message = "Remaining Grace Marks: $graceMarks are utilized For Next Sem";
            $_SESSION['messages'][] = $message;
        }
    } else {
        $message = "No marks found for the student.";
        $_SESSION['messages'][] = $message;
    }
} else {
    $message = "Student not found.";
    $_SESSION['messages'][] = $message;
}

// Close the database connection
$conn->close();

function getSubjectCredits($subject) {
    // Replace this with your logic to retrieve the credits for the subject from the database or any other source
    $subjectCredits = [
        'dsa' => 3,
        'popl' => 4,
        'os' => 3,
        'ml' => 3,
        'fods' => 4,
        'se' => 3,
    ];

    return $subjectCredits[$subject] ?? 0; // Return 0 if subject credits are not found
}

function calculateReqMark($marks) {
    if ($marks >= 85) {
        return 0;
    } elseif ($marks >= 80 && $marks < 85) {
        return 85 - $marks;
    } elseif ($marks >= 75 && $marks < 80) {
        return 80 - $marks;
    } elseif ($marks >= 70 && $marks < 75) {
        return 75 - $marks;
    } else {
        return 70 - $marks;
    }
}

function calculateGrade($marks) {
    if ($marks >= 85) {
        return 'A';
    } elseif ($marks >= 80 && $marks < 85) {
        return 'B+';
    } elseif ($marks >= 75 && $marks < 80) {
        return 'B';
    } elseif ($marks >= 70 && $marks < 75) {
        return 'C+';
    } elseif ($marks >= 60 && $marks < 70) {
        return 'C';
    } else {
        return 'F';
    }
}



header("Location: addgrace.php");
exit();
?>
