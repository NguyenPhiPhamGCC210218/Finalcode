$(document).ready(function () {
  $("#login_admin_form").submit(function (e) {
    e.preventDefault();
    const username = $("#txtUsername").val();
    const pass = $("#txtPass").val();
    if (!username || !pass) {
      alert("Enter username and password, please!");
      return;
    }

    const form_data = new FormData();
    form_data.append("username", username);
    form_data.append("pass", pass);

    fetch("http://localhost:1000/management/login_admin_api.php", {
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

        if (data.role == "customer_care") {
          document.cookie = `user_id=${data.id}; path=/`;
          GetUserToken(data);
        } else {
          location.href = "management/index.php";
        }
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
          location.href = "management/index.php";
        }
      })
      .catch((e) => {
        console.log(e);
      });
  }
});
