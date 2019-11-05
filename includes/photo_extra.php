<!Doctype html>
<html>
<style>
.btn-group button {
  background-color: grey;
  border: 1px solid #f1f1f1;
  color: white;
  padding: 10px 24px;
  cursor: pointer;
  float: left;
  width: 380px;
}

.btn-group:after {
  content: "";
  clear: both;
  display: table;
}

.btn-group button:not(:last-child) {
  border-right: none;
}

.btn-group button:hover {
  background-color: black;
}
</style>
<body>

<div class="btn-group">
  <button onclick="window.location.href='like_pic.php'">like</button>
  <button onclick="window.location.href='delete_pic.php'">delete</button>
</div>

</body>
</html>
