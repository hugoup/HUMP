<template>
	<div class="info">
		<h1>Welcome to <Hump/>-Debugger !!</h1>
		<p>Simple way of debugging code localy without disrupting the flow of the code.</p>
		<br>
		Remember to add the following to your docker-compose-file.
		<pre><code>extra_hosts:
    - "host.docker.internal:host-gateway"</code></pre>
		If you are using <Hump/> from inside a docker-container.
	</div>
</template>

<style lang="scss">
.info {
	place-self: center;
	padding: 20px;
	background-color: var(--background-light);
	border-radius: 5px;
	box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);

	pre {
		background-color: var(--background-dark);
		padding: 10px;
	}
}
</style>
