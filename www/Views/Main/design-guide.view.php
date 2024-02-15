<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>design guide</title>
		<link rel="stylesheet" type="text/css" href="../../easycook-vite/dist/css/style.css" />
	</head>
	<body>
		<style>
			.content{
				background-color: blue;
				height: 2rem;
			}
		</style>
		<section>
			<h1>.button</h1>
			<hr />
			<p>
				<button class="button button-primary button-lg">Button</button>
				<button class="button button-primary">Button</button>
				<button class="button button-primary button-sm">Button</button>
			</p>
			<p>
				<a href="#" class="button button-secondary button-lg">Button</a>
				<a href="#" class="button button-secondary">Button</a>
				<a href="#" class="button button-secondary button-sm">Button</a>
			</p>
			<p>
				<a href="#" class="button button-danger button-lg">Button</a>
				<a href="#" class="button button-danger">Button</a>
				<a href="#" class="button button-danger button-sm">Button</a>
			</p>
            <p>
				<a href="#" class="button button-brown button-lg">Button</a>
				<a href="#" class="button button-brown">Button</a>
				<a href="#" class="button button-brown button-sm">Button</a>
			</p>
            <p>
				<a href="#" class="button button-dark-grey button-lg">Button</a>
				<a href="#" class="button button-dark-grey">Button</a>
				<a href="#" class="button button-dark-grey button-sm">Button</a>
			</p>
		</section>
		<section>
			<h1>.banner</h1>
			<hr />
			<div class="banner" style="background-image: url('assets/images/fond.png');"></div>
			<br>
			<div class="banner banner-text" style="background-image: url('assets/images/fond.png');">
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
			 Cras ullamcorper nulla a ipsum imperdiet, ac porttitor dui sagittis.</p>
			</div>
		</section>
		<section>
			<h1>.card</h1>
			<hr />
			<article class="card">
				<img src="assets/images/Tororo.png">
				<h1>Cart title</h1>
				<p>Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				<a href="#" class="button button-primary button-sm"> Button </a>

			</article>
			
		</section>
		<section>
			<h1>.card</h1>
			<hr />
			<article class="card card-full">
				<img src="assets/images/Tororo.png">
				<h1>Cart title</h1>
				<p>Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				<a href="#" class="button button-primary button-sm"> Button </a>

			</article>
			
		</section>
		<section>
			<h1>.grid</h1>
			<hr>
			<div class="grid">
				<div class="row">
					<div class="col-2"><div class="content"></div></div>
					<div class="col-2"><div class="content"></div></div>
					<div class="col-8"><div class="content"></div></div>
				</div>
		
			</div>
		</section>
		<section>
			<h1>.form</h1>
			<hr>
		<form>
			<div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			</div>
			<div class="form-group form-check">
				<input type="checkbox" class="form-check-input" id="exampleCheck1">
				<label class="form-check-label" for="exampleCheck1">Check me out</label>
			</div>
			<button type="submit" class="button button-primary">Submit</button>
		</form>
		</section>
	</body>
</html>
