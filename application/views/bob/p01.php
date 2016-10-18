<h2>Build Your Coffee <img src="/images/logo.png"/></h2>

<form method="post" action="/generating/showme">
	Your name: <input type="text" name="name"/><br/>
	Size: <input type="radio" name="size" value="sm" checked> Small</input>
	<input type="radio" name="size" value="md"/> Medium
	<input type="radio" name="size" value="lg"/> Large
	<input type="radio" name="size" value="hu"/> Ludicrous<br/>
	Cup composition: <select name="cup">
		<option value="paper">Paper</option>
		<option value="steel">Stainless</option>
		<option value="glaze">Porcelain</option>
	</select><br/>
	Options? <input type="checkbox" name="opt1" checked/> Caramel sauce
	<input type="checkbox" name="opt2"/> Sprinkles
	<input type="checkbox" name="opt3" checked/> Ketchup<br/>
	# of extra shots: <input type="number" name="extra" min="0" max="3" value="1"/><br/>
	Special instructions? <textarea name="message" rows="3" cols="30"></textarea><br/>
	<input type="submit" value="Please"/>
</form>