<?php
/*
function assertEquals($actual, $expected, $message) {
	if ($actual != $expected) {
		error_log('Failed asserting that '.$actual.' equals '.$expected.' : '.$message);
	} else {
		error_log('Passed: '.$message);
	}
}
*/

function assertTrue($actual, $message) {
	if ($actual != true) {
		error_log('Failed asserting that '.$actual.' equals '.'true'.' : '.$message);
	} else {
		error_log('Passed: '.$message);
	}
}

function assertFalse($actual, $message) {
	if ($actual != false) {
		error_log('Failed asserting that '.$actual.' equals '.'false'.' : '.$message);
	} else {
		error_log('Passed: '.$message);
	}
}



