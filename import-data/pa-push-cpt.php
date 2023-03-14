<?php 

function pushcpt()
{
   if (import_cabins()) {
      echo "import_cabins executed successfully.<br>";
  } else {
      echo "import_cabins failed to execute.<br>";
  }

  if (import_countries()) {
      echo "import_countries executed successfully.<br>";
  } else {
      echo "import_countries failed to execute.<br>";
  }
}