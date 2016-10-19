{heading}

<form method="post" action="/generating/showme">
	Your name: <input type="text" name="name" value="{name}"/><br/>
	Size: <input type="radio" name="size" value="sm" {checked-sm}/> Small
	<input type="radio" name="size" value="md" {checked-md}/> Medium
	<input type="radio" name="size" value="lg" {checked-lg}/> Large
	<input type="radio" name="size" value="hu" {checked-hu}/> Ludicrous<br/>
	Cup composition: <select name="cup">
		<option value="paper" {select-paper}>Paper</option>
		<option value="steel" {select-steel}>Stainless</option>
		<option value="glaze" {select-glaze}>Porcelain</option>
	</select><br/>
	Options? <input type="checkbox" name="opt1" value="sweet" {checked-opt1}/> Caramel sauce
	<input type="checkbox" name="opt2" value="sprink" {checked-opt2}/> Sprinkles
	<input type="checkbox" name="opt3" value="cats" {checked-opt3}/> Ketchup<br/>
	# of extra shots: <input type="number" name="extra" min="0" max="3" value="{extra}"/><br/>
	Special instructions? <textarea name="message" rows="3" cols="30">{message}</textarea><br/>
	<input type="submit" value="Please"/>
</form>