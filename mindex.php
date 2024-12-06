<?php
session_start();
require 'db_connection.php';

// Generate a unique exam ID if not already set
if (!isset($_SESSION['exam_id'])) {
    $_SESSION['exam_id'] = substr(md5(uniqid(rand(), true)), 0, 8); // Unique 8-character ID
    $exam_id = $_SESSION['exam_id'];

    // Insert the exam into the database
    $stmt = $conn->prepare("INSERT INTO exams (exam_id) VALUES (?)");
    $stmt->bind_param("s", $exam_id);
    $stmt->execute();
    $stmt->close();
} else {
    $exam_id = $_SESSION['exam_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exam</title>
</head>
<body>
    <h1>Create an MCQ Exam</h1>
    <p><strong>Exam ID:</strong> <?php echo $exam_id; ?></p>

    <form action="add_question.php" method="POST">
        <!-- Question Input -->
        <label for="question">Question:</label><br>
        <textarea name="question" id="question" rows="4" cols="50" required></textarea><br>

        <!-- Options Input -->
        <label for="option_a">Option A:</label><br>
        <input type="text" name="option_a" id="option_a" required><br>

        <label for="option_b">Option B:</label><br>
        <input type="text" name="option_b" id="option_b" required><br>

        <label for="option_c">Option C:</label><br>
        <input type="text" name="option_c" id="option_c" required><br>

        <label for="option_d">Option D:</label><br>
        <input type="text" name="option_d" id="option_d" required><br>

        <!-- Correct Answer Input -->
        	
        <label for="correct_answer">Correct Answer (A/B/C/D):</label><br>
<select name="correct_answer" id="correct_answer" required>
    <option value="">Select an answer</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
</select><br>
        	

 
        <!-- Submit Button -->
        <button type="submit">Add Question</button>
    </form>
<br><br><br>
    <form action="finish.php" method="POST">
    	
    <!-- Time Input -->
        <label for="time_limit">Time Limit (Minutes):</label><br>
        <input type="number" name="time_limit" id="time_limit" min="1" required><br><br>
        <!-- Finish Adding Button -->
        <button type="submit">Finish Adding Questions</button>
    </form>
</body>
</html>