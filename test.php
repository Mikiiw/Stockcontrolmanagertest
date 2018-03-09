
<?PHP
// require './connection.php';
$con = mysqli_connect("localhost", "root", "", "testing123");
if (mysqli_connect_errno()){
echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    echo "Connection successful";
}
$q = mysqli_query($con, "SELECT * FROM stockcontrol");
?>
