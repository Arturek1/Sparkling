<?php
/**
 * Template name: IP homepage
 */
get_header(); ?>
	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) :
				the_post();
            ?>
				<div id="ip">
					<?php 
							 function get_geolocation($ip) {
								try {
									// $url = "https://api.ipgeolocationapi.com/geolocate/".$ip;
									$url = "http://ip-api.com/json/".$ip."?fields=continent,country,countryCode,region,regionName,city,district,zip,lat,lon,currency,isp,org,as,asname,reverse,mobile,proxy";
									$cURL = curl_init();
							
									curl_setopt($cURL, CURLOPT_URL, $url);
									curl_setopt($cURL, CURLOPT_HTTPGET, true);
									curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
										'Content-Type: application/json',
										'Accept: application/json'
									));
	
									return curl_exec($cURL);
								} catch (Exception $e) {
									return 'Unknown error!';
								}
							}

						$ip = $_SERVER['REMOTE_ADDR'];
						if($ip == '::1') {
							$ip = '5.226.98.19';
						}

						$geo = json_decode(get_geolocation($ip), true);
						$longitude = $geo['lon'];
						$latitude = $geo['lat'];

						$map_src = "https://embed.waze.com/iframe?zoom=16&
						lat=".$latitude."&
						lon=".$longitude."
						&ct=livemap";
					?>
				<div class="map">
					<div class="myip">
						<span>My IP address is: </span>
						<span class="ip-address">
							<?php 
								echo $ip;
							?>
						</span>
					</div>
						<div id="mapid"></div>
						<script>
							let longitude = parseFloat("<?php echo $longitude; ?>").toFixed(4);
							let latitude =  parseFloat("<?php echo $latitude; ?>").toFixed(4);

							var mymap = L.map('mapid').setView([latitude, longitude], 4);
							L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiYXJ0dXJlayIsImEiOiJjazFwbnp3ZDMwMzV1M29rNHd2MHphdWswIn0.PEGUOGpQjxc5oX8wyb5q_g', {
							attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
							maxZoom: 18,
							id: 'mapbox.streets'
						}).addTo(mymap);
						var marker = L.marker([latitude, longitude]).addTo(mymap);
						</script>
					<table class="table table-hover">
					<tbody>
						<tr>
							<td scope="row">IP address:</td>
							<td><?php echo $ip; ?></td>
						</tr>
						<tr>
							<td scope="row">ISP:</td>
							<td><?php echo $geo['isp']; ?></td>
						</tr>
						<tr>
							<td scope="row">DNS server:</td>
							<td><?php echo $geo['reverse']; ?></td>
						</tr>
						<tr>
							<td scope="row">Country:</td>
							<td><?php echo $geo['country']; ?></td>
						</tr>
						<tr>
							<td scope="row">Region:</td>
							<td><?php echo $geo['regionName']; ?></td>
						</tr>
						<tr>
							<td scope="row">City:</td>
							<td><?php echo $geo['city']; ?></td>
						</tr>
						<tr>
							<td scope="row">Zip code:</td>
							<td><?php echo $geo['zip']; ?></td>
						</tr>
						<tr>
							<td scope="row">Country code:</td>
							<td><?php echo $geo['countryCode']; ?></td>
						</tr>
						<tr>
							<td scope="row">Continent:</td>
							<td><?php echo $geo['continent']; ?></td>
						</tr>
						<tr>
							<td scope="row">Latitude:</td>
							<td><?php echo $latitude; ?></td>
						</tr>
						<tr>
							<td scope="row">Longitude:</td>
							<td><?php echo $longitude; ?></td>
						</tr>
					</tbody>
					</table>
				</div>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php
					// If comments are open or we have at least one comment, load up the comment template
				if ( get_theme_mod( 'sparkling_page_comments', 1 ) == 1 ) :
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
						endif;
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
