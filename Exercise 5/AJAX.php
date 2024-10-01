<!DOCTYPE HTML>  
<html>
<head>
<style>
body {
  background: linear-gradient(to right, #feac5e, #c779d0, #4bc0c8);
  font-family: Arial, sans-serif;
  color: white;
  margin: 0;
  padding: 0;
  height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
}

h2 {
  text-align: center;
  margin-top: 20px;
  font-size: 36px;
}

form, .input-result {
  background-color: rgba(0, 0, 0, 0.7); 
  padding: 20px;
  border-radius: 10px;
  width: 400px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  margin: 10px;
}

input[type="text"] {
  width: 100%;
  padding: 5px;
  margin: 5px 0 10px;
  border: none;
  border-radius: 5px;
}

input[type="radio"] {
  margin: 0 10px;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

.error {
  color: #FF0000;
}

p {
  text-align: center;
}

span#firstNameHint, span#lastNameHint {
  color: lightyellow;
  font-size: 12px;
}

.input-result {
  text-align: center;
  color: white;
}

</style>
<script>

const firstNames = ["Jansent", "Janna", "Jocel", "Camella", "Cathy", "Niña"];
const lastNames = ["Bazar", "Roldan", "Encio", "Escalon", "Dela Cruz", "Dionisio"];

function showHint(str, field) {
  let suggestions = [];
  if (str.length === 0) {
    document.getElementById(field + "Hint").innerHTML = "";
    return;
  } else {
    const nameArray = field === "firstName" ? firstNames : lastNames;
    suggestions = nameArray.filter(name => name.toLowerCase().startsWith(str.toLowerCase()));
    
    document.getElementById(field + "Hint").innerHTML = suggestions.length > 0 ? suggestions.join(", ") : "No suggestions";
  }
}

</script>
</head>
<body>  

<?php
$firstNameErr = $lastNameErr = $ageErr = $genderErr = $hobbiesErr = "";
$firstName = $lastName = $age = $gender = $hobbies = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstName"])) {
    $firstNameErr = "First name is required";
  } else {
    $firstName = test_input($_POST["firstName"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
      $firstNameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["lastName"])) {
    $lastNameErr = "Last name is required";
  } else {
    $lastName = test_input($_POST["lastName"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $lastName)) {
      $lastNameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["age"])) {
    $ageErr = "Age is required";
  } else {
    $age = test_input($_POST["age"]);
    if (!filter_var($age, FILTER_VALIDATE_INT) || $age <= 0) {
      $ageErr = "Please enter a valid age";
    }
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }

  if (empty($_POST["hobbies"])) {
    $hobbiesErr = "At least one hobby is required";
  } else {
    $hobbies = test_input($_POST["hobbies"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>FORM TEAM</h2>
<p><span class="error">* Required field *</span></p>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  First Name: <input type="text" name="firstName" value="<?php echo $firstName; ?>" onkeyup="showHint(this.value, 'firstName')">
  <span class="error">* <?php echo $firstNameErr;?></span>
  <p>Suggestions: <span id="firstNameHint"></span></p>
  
  Last Name: <input type="text" name="lastName" value="<?php echo $lastName; ?>" onkeyup="showHint(this.value, 'lastName')">
  <span class="error">* <?php echo $lastNameErr;?></span>
  <p>Suggestions: <span id="lastNameHint"></span></p>

  Age: <input type="text" name="age" value="<?php echo $age; ?>">
  <span class="error">* <?php echo $ageErr;?></span>

  <br><br>
  Gender:
  <input type="radio" name="gender" value="female" <?php if (isset($gender) && $gender == "female") echo "checked";?>>Female
  <input type="radio" name="gender" value="male" <?php if (isset($gender) && $gender == "male") echo "checked";?>>Male
  <input type="radio" name="gender" value="other" <?php if (isset($gender) && $gender == "other") echo "checked";?>>Other
  <span class="error">* <?php echo $genderErr;?></span>

  <br><br>
  Hobbies: <input type="text" name="hobbies" value="<?php echo $hobbies; ?>">
  <span class="error">* <?php echo $hobbiesErr;?></span>

  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($firstNameErr) && empty($lastNameErr) && empty($ageErr) && empty($genderErr) && empty($hobbiesErr)) {
    echo "<div class='input-result'>";
    echo "<h2>Your Input:</h2>";
    echo "First Name: " . $firstName . "<br>";
    echo "Last Name: " . $lastName . "<br>";
    echo "Age: " . $age . "<br>";
    echo "Gender: " . $gender . "<br>";
    echo "Hobbies: " . $hobbies;
    echo "</div>";
}
?>

</body>
</html>
