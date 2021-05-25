function seedQuestReportComplete(words, encode) {
	console.log(words, encode);
	var req = new XMLHttpRequest();
	req.open("POST", "../index.php/credit");
	req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	req.send("words=" + encodeURIComponent(words) + "&encode=" + (encode ? 1 : 0));
}
