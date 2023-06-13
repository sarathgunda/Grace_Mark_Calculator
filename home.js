

  function showData() {
    var peopleList;
    if (localStorage.getItem("peopleList") == null) {
      peopleList = [];
    } else {
      peopleList = JSON.parse(localStorage.getItem("peopleList"));
    }
    var html = "";
    peopleList.forEach(function (element, index) {
      html += "<tr>";
      html += "<td>" + element.name + "</td>";
      html += "<td>" + element.rollnumber + "</td>";
      html += "<td>" + element.category + "</td>";
      html += "<td>" + element.subCategory + "</td>";
      html += "<td>" + element.marks + "</td>";
      html +=
        '<td><button onclick="deleteData(' +
        index +
        ')" class="btn btn-danger">Delete</button><button onclick="updateData(' +
        index +
        ')" class="btn btn-warning m-2">Edit</button></td>';
      html += "</tr>";
    });
    document.querySelector("#crudTable tbody").innerHTML = html;
  }
  
  // Function to add data
  function addData() {
    var name = document.getElementById("name").value;
    var rollnumber = document.getElementById("rollnumber").value;
    var category = document.getElementById("category").value;
    var subCategory = document.getElementById("subCategory").value;
    var marks = document.getElementById("marks").value;
  
    if (!validateForm(name, rollnumber, category, subCategory, marks)) {
      return; // If form validation fails, exit the function
    }
  
    var peopleList;
    if (localStorage.getItem("peopleList") == null) {
      peopleList = [];
    } else {
      peopleList = JSON.parse(localStorage.getItem("peopleList"));
    }
  
    peopleList.push({
      name: name,
      rollnumber: rollnumber,
      category: category,
      subCategory: subCategory,
      marks: marks,
    });
  
    localStorage.setItem("peopleList", JSON.stringify(peopleList));
    showData();
    clearForm();

    sendDataToPHP({
      name: name,
      rollnumber: rollnumber,
      category: category,
      subCategory: subCategory,
      marks: marks,
    });
  }
  function sendDataToPHP(data) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText);
      }
    };
    xhr.send(JSON.stringify(data));
  }
  
  // Function to delete data
  function deleteData(index) {
    var peopleList;
    if (localStorage.getItem("peopleList") == null) {
      peopleList = [];
    } else {
      peopleList = JSON.parse(localStorage.getItem("peopleList"));
    }
    var rollnumber = peopleList[index].rollnumber;
    var activity = peopleList[index].subCategory;
  
    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  
    // Send the roll number and activity to the PHP script
    xhr.send("rollnumber=" + rollnumber + "&activity=" + activity);
  
    // Handle the response from the PHP script
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Request successful, perform any necessary actions
          console.log(xhr.responseText);
        } else {
          // Request failed, handle the error
          console.error("Failed to delete data");
        }
      }
    };
  
    // Remove the data item from the peopleList array in local storage
    peopleList.splice(index, 1);
    localStorage.setItem("peopleList", JSON.stringify(peopleList));
  
    // Update the displayed data
    showData();

  }
  
  // Function to update/edit data
  function updateData(index) {
    document.getElementById("submitBtn").style.display = "none";
    document.getElementById("updateBtn").style.display = "block";
  
    var peopleList;
    if (localStorage.getItem("peopleList") == null) {
      peopleList = [];
    } else {
      peopleList = JSON.parse(localStorage.getItem("peopleList"));
    }
  
    document.getElementById("name").value = peopleList[index].name;
    document.getElementById("rollnumber").value = peopleList[index].rollnumber;
    document.getElementById("category").value = peopleList[index].category;
    document.getElementById("subCategory").value = peopleList[index].subCategory;
    document.getElementById("marks").value = peopleList[index].marks;
  
    document.getElementById("updateBtn").onclick = function () {
      var name = document.getElementById("name").value;
      var rollnumber = document.getElementById("rollnumber").value;
      var category = document.getElementById("category").value;
      var subCategory = document.getElementById("subCategory").value;
      var marks = document.getElementById("marks").value;
  
      if (!validateForm(name, rollnumber, category, subCategory, marks)) {
        return; // If form validation fails, exit the function
      }
  
      peopleList[index].name = name;
      peopleList[index].rollnumber = rollnumber;
      peopleList[index].category = category;
      peopleList[index].subCategory = subCategory;
      peopleList[index].marks = marks;
  
      localStorage.setItem("peopleList", JSON.stringify(peopleList));
      showData();
      clearForm();
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "update.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
      // Send the roll number and activity to the PHP script
      xhr.send("rollnumber=" + rollnumber + "&activity=" + subCategory + "&Name=" + name + "&category=" + category + "&Marks=" + marks);

    
      // Handle the response from the PHP script
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Request successful, perform any necessary actions
            console.log(xhr.responseText);
          } else {
            // Request failed, handle the error
            console.error("Failed to update data");
          }
        }
      };

  
      document.getElementById("submitBtn").style.display = "block";
      document.getElementById("updateBtn").style.display = "none";
    };
  }
  
  // Function to validate the form inputs
  function validateForm(name, rollnumber, category, subCategory, marks) {
    var isValid = true;
  
    // Validate name (should be more than 3 characters)
    if (name.length < 3) {
      document.getElementById("nameError").innerText =
        "Name should be more than 3 characters";
      isValid = false;
    } else {
      document.getElementById("nameError").innerText = "";
    }
  
    // Validate roll number (should start with 'cb.en.u4' followed by any characters)
    var rollNumberPattern = /^cb\.en\.u4/;
    if (!rollNumberPattern.test(rollnumber)) {
      document.getElementById("rollNumberError").innerText =
        "Roll number should start with 'cb.en.u4'";
      isValid = false;
    } else {
      document.getElementById("rollNumberError").innerText = "";
    }
  
    // Validate category (should not be an empty option)
    if (category === "") {
      document.getElementById("categoryError").innerText =
        "Please choose a category";
      isValid = false;
    } else {
      document.getElementById("categoryError").innerText = "";
    }
  
    // Validate sub-category (should not be an empty option)
    if (subCategory === "") {
      document.getElementById("subCategoryError").innerText =
        "Please choose a sub-category";
      isValid = false;
    } else {
      document.getElementById("subCategoryError").innerText = "";
    }
  
    // Validate marks (should be between 1 and 10)
    if (marks < 1 || marks > 10) {
      document.getElementById("marksError").innerText =
        "Marks should be between 1 and 10";
      isValid = false;
    } else {
      document.getElementById("marksError").innerText = "";
    }
  
    return isValid;
  }
  
  // Function to clear the form inputs
  function clearForm() {
    document.getElementById("name").value = "";
    document.getElementById("rollnumber").value = "";
    document.getElementById("category").value = "";
    document.getElementById("subCategory").value = "";
    document.getElementById("marks").value = "";
  }
  function updateSubcategoryOptions() {
    var category = document.getElementById("category").value;
  var subCategorySelect = document.getElementById("subCategory");

  // Clear existing options
  subCategorySelect.innerHTML = "";

  // Create new options based on the selected category
  if (category === "Sports") {
    var options = [
      { value: "SPG 01", marks: 5 },
      { value: "SPG 02", marks: 4 },
      { value: "SPG 03", marks: 3 },
      { value: "SPG 04", marks: 3 },
      { value: "SPG 05", marks: 7 },
      { value: "SPG 06", marks: 6 },
      { value: "SPG 07", marks: 5 },
      { value: "SPG 08", marks: 3 },
      // Add more options and their corresponding marks here
    ];
    options.forEach(function (option) {
      var optionElement = document.createElement("option");
      optionElement.value = option.value;
      optionElement.text = option.value;
      subCategorySelect.appendChild(optionElement);
    });

    // Automatically set the marks field based on the selected subcategory
    subCategorySelect.addEventListener("change", function () {
      var selectedOption = subCategorySelect.value;
      var marksField = document.getElementById("marks");

      // Find the corresponding marks for the selected subcategory
      var selectedMarks = options.find(function (option) {
        return option.value === selectedOption;
      }).marks;

      // Set the marks field value
      marksField.value = selectedMarks;
    });
    } else if (category === "Cultural") {
        var options = [
            { value: "CUL 01", marks: 5 },
            { value: "CUL 02", marks: 4 },
            { value: "CUL 03", marks: 3 },
            { value: "CUL 04", marks: 3 },
            { value: "CUL 05", marks: 7 },
            { value: "CUL 06", marks: 6 },
            { value: "CUL 07", marks: 5 },
            { value: "CUL 08", marks: 3 },
            // Add more options and their corresponding marks here
          ];
          options.forEach(function (option) {
            var optionElement = document.createElement("option");
            optionElement.value = option.value;
            optionElement.text = option.value;
            subCategorySelect.appendChild(optionElement);
          });
      
          // Automatically set the marks field based on the selected subcategory
          subCategorySelect.addEventListener("change", function () {
            var selectedOption = subCategorySelect.value;
            var marksField = document.getElementById("marks");
      
            // Find the corresponding marks for the selected subcategory
            var selectedMarks = options.find(function (option) {
              return option.value === selectedOption;
            }).marks;
      
            // Set the marks field value
            marksField.value = selectedMarks;
          });
      
    }
    else if (category === "Technical") {
        var options = [
            { value: "TEC 01", marks: 6 },
            { value: "TEC 02", marks: 5 },
            { value: "TEC 03", marks: 4 },
            { value: "TEC 04", marks: 8 },
            { value: "TEC 05", marks: 7 },
            { value: "TEC 06", marks: 6 },
            // Add more options and their corresponding marks here
          ];
          options.forEach(function (option) {
            var optionElement = document.createElement("option");
            optionElement.value = option.value;
            optionElement.text = option.value;
            subCategorySelect.appendChild(optionElement);
          });
      
          // Automatically set the marks field based on the selected subcategory
          subCategorySelect.addEventListener("change", function () {
            var selectedOption = subCategorySelect.value;
            var marksField = document.getElementById("marks");
      
            // Find the corresponding marks for the selected subcategory
            var selectedMarks = options.find(function (option) {
              return option.value === selectedOption;
            }).marks;
      
            // Set the marks field value
            marksField.value = selectedMarks;
          });
    }
    else if (category === "Seva") {
        var options = [
            { value: "SEV 01", marks: 3 },
            { value: "SEV 02", marks: 5 },
            // Add more options and their corresponding marks here
          ];
          options.forEach(function (option) {
            var optionElement = document.createElement("option");
            optionElement.value = option.value;
            optionElement.text = option.value;
            subCategorySelect.appendChild(optionElement);
          });
      
          // Automatically set the marks field based on the selected subcategory
          subCategorySelect.addEventListener("change", function () {
            var selectedOption = subCategorySelect.value;
            var marksField = document.getElementById("marks");
      
            // Find the corresponding marks for the selected subcategory
            var selectedMarks = options.find(function (option) {
              return option.value === selectedOption;
            }).marks;
      
            // Set the marks field value
            marksField.value = selectedMarks;
          }).marks;
    }
  }
  document.getElementById("category").addEventListener("change", updateSubcategoryOptions);
  
  // Call the updateSubcategoryOptions function initially to set the subcategory options based on the default category
  updateSubcategoryOptions();
  
  // Event listener for submitting the form
  document.getElementById("submitBtn").addEventListener("click", addData);
  
  // Call the showData function to load the existing data on page load
  showData();
  