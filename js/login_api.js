$(document).ready(function () {
  $("#login_form").submit(function (e) {
    e.preventDefault();
    const username = $("#txtUsername").val();
    const pass = $("#txtPass").val();
    const term = $("#terms");

    if (!username || !pass) {
      alert("Enter username and password, please!");
      return;
    }

    if (!term.is(":checked")) {
      alert("Agree to terms and services, please!");
      return;
    }

    const form_data = new FormData();
    form_data.append("username", username);
    form_data.append("pass", pass);

    fetch("http://localhost:1000/login_api.php", {
      method: "POST",
      body: form_data,
    })
      .then(async (res) => {
        const data = await res.json();
        console.log(data);

        if (data.status_code == 400) {
          alert("Wrong username or password");
          return;
        }
        document.cookie = `user_id=${data.id}; path=/`;
        GetUserToken(data);
      })
      .catch((e) => {
        console.log(e);
      });
  });

  function GetUserToken(data) {
    fetch("http://localhost:3000/api/auth/get-user-token", {
      method: "POST",
      body: JSON.stringify(data),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then(async (res) => {
        const data = await res.json();
        if (data.status_code == 200) {
          document.cookie = `user_token=${data.token}; path=/`;
          location.href = "index.php";
        }
      })
      .catch((e) => {
        console.log(e);
      });
  }
});
