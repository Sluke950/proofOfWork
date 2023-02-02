<?php

/*

proof.php - example proof of work script.

Author: Greg Probst - greg@icdesigns.com

Modification History:

Overview:

Example of proof of work algorithm.

Change the various values to see how small changes in any of the values can yield different results.

proofLength - this is the length of the proof string - the longer it is, in theory the longer it should take.

proofChar - the character that is prefixed, e.g. "0" for proofLength of 3 will yield a proofString of "000" in hex, e.g. 12 bits of zero.

proofString - the proof string required for the hash match that signifies a magic number.

Since the hash() function returns hex values, each proofChar, e.g. "0" is 4 bits of "0000"

Hash Algorithm options: sha1, sha256, md5

Other hash algorithms can be found at: https://www.php.net/manual/en/function.hash-algos.php

*/


/* Set up the parameters.  */

$proofLength = 5;
$proofString = "";
$proofChar = "0";
$startTime = microtime(true);
$endTime = $startTime;

$hashAlgorithm = "sha256";

$dataString = "This is the data that you can modify if you wish - a simple change will yield different results and magic numbers.";

/* 
   This is a nested function call - the result of hash() is passed in strlen() and the result from the outer strlen is
   multiplied by 4 because the hash returns a string in hex.
*/

$sizeOfHash = 4*strlen(hash($hashAlgorithm,"data in hash doesn't matter - the hash algorithm will yield same length."));

echo "The hash algorithm $hashAlgorithm will yield a string of $sizeOfHash bits.\n";

/* Just a limit to the number search attempts - most miners will run this indefintely. */

$maxTries = 100000000;

/* Create the proof string */

for ($i=0; $i<$proofLength; $i++) {
   $proofString .= $proofChar;
}

echo "Proof string of size($proofLength) : $proofString\n";
echo "Max tries = $maxTries\n";

for ( $magicNumber = 0; $magicNumber < $maxTries; $magicNumber++ ) {

   /* Append the magic number to the data */

   $orig = hash($hashAlgorithm,$dataString.sprintf("%s",$magicNumber));

   /* See if the prefix of the hash result equals the proof string */

   if ( substr($orig,0,$proofLength) === $proofString ) {
      $endTime = microtime(true);
      echo "\nMagic number found $magicNumber attempts with hash: ".$orig."\n";
      echo "Time elapsed: ".sprintf("%.10f",$endTime-$startTime)." secs. \n";
      die();
   }

   /* Print a period or some indicator every 100 attempts. */

   if ( $magicNumber%100 === 0 ) {
      echo ".";
   }

}


