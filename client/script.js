let user = {
  id: 1,
  login: "user1",
  password: 1234,
  role: 0,
};

let auth = false;

let sideboard = $("#sideboard").get(0);

if (auth) {
  if (user["role"] == 0) {
    sideboard.innerHTML += `<li class="nav-item m-1">
    <button class="bg-primary text-bg-primary nav-link active w-100" aria-current="page">
            Home
    </button>
</li>
<li class="nav-item m-1">
    <button class="bg-primary text-bg-primary nav-link active w-100" aria-current="page">
            Posts
    </button>
</li>

<li class="nav-item m-1">
    <button class="bg-primary text-bg-primary nav-link active w-100" aria-current="page">
            Comments
    </button>
</li>

<li class="nav-item m-1">
    <button class="bg-primary text-bg-primary nav-link active w-100" aria-current="page">
            Users
    </button>
</li>

<li class="nav-item m-1">
      <button class="nav-link bg-danger text-bg-danger w-100" aria-current="page">
        Sign Out
      </button>
    </li>
`;
  } else {
    sideboard.innerHTML += `<li class="nav-item m-1">
    <a href="#" class="nav-link active" aria-current="page">
            Home
    </a>
</li>

<li class="nav-item m-1">
    <a href="#" class="nav-link active" aria-current="page">
            Posts
    </a>
</li>

<li class="nav-item m-1">
      <button class="nav-link bg-danger text-bg-danger w-100" aria-current="page">
        Sign Out
      </button>
    </li>


`;
  }
} else {
  sideboard.innerHTML += `<li class="nav-item m-1">
  <button class="bg-primary text-bg-primary nav-link active w-100" aria-current="page">
     Home
  </button>
</li>
      
      <li class="nav-item m-1">
      <a href="auth.html" class="nav-link active text-center" aria-current="page">
        Sign In
      </a>
    </li>

      `;
}
