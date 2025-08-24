<?php

return [
	"/" => (new Controllers\Index())->index(),
	"/j" => (new Controllers\Test())->index(),
];

