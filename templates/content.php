<?php

echo '<ul>
	<li><a href="/page1">Page 1</a></li>
	<li><a href="/page2">Page 2</a></li>
	<li><a href="/page3">Page 3</a></li>
</ul>';

echo '<form action="" method="post">
	<button type="submit" name="submit_history" value="1">Back</button>
	<input type="hidden" name="action" value="back" />
</form>';

$historyList = $History->list();
echo '<form action="" method="post">';
for ($historyIndex = 0; $historyIndex < count($historyList); $historyIndex++) {
	$Node = $historyList[$historyIndex];
	echo '<li><button type="submit" name="index" value="' . $historyIndex . '">' . $Node->title . '</button></li>';
}
echo '<input type="hidden" name="action" value="goTo" />
	<input type="hidden" name="submit_history" value="1" />
</form>';

echo '<form action="" method="post">
	<button type="submit" name="submit_history" value="1">Forward</button>
	<input type="hidden" name="action" value="forward" />
</form>';
