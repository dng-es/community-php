<table>
	<thead>
		<tr>
			<td>
				<table>
					<tr>
						<td>
							<img src="{SiteUrl}/images/logo.png" />
						</td>
						<td width="100%">
							<h1>{title_email}</h1>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</thead>
	<tr>
		<td>
			<br />
			<p>{text_email}.</p>
			<b>Número de pedido</b>: {id_order}<br />
			<b>Fecha de pedido</b>: {date_order}<br />
			<b>Estado del pedido</b>: {status_order}
			<b>Observaciones del pedido</b>: {notes_order}
			<hr />
			<h3>Datos de entrega</h3>
			<b>Nombre</b>: {name_order}<br />
			<b>Apellidos</b>: {surname_order}<br />
			<b>Teléfono de contacto</b>: {telephone_order}<br />
			<b>Concesión</b>: {address_order}<br />
			<b>Dirección</b>: {address2_order}<br />
			<b>Localidad</b>: {city_order}<br />
			<b>Provincia</b>: {state_order}<br />
			<b>C. Postal</b>: {postal_order}
			<hr />
			<h3>Artículos</h3>
			<table border="1" cellpadding=10 cellspacing=0>
				<thead>
					<tr>
						<th width="100%" align="left">Artículo</th>
						<th align="center">Cantidad</th>
						<th align="center">{credits_label}</th>
					</tr>
				</thead>
				<tr>
					<td>{product_name}</td>
					<td align="center">{product_ammount}</td>
					<td align="center">{product_price}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<hr />
			<p>{SiteTitle} - <a href="{SiteUrl}">{SiteUrl}</a> - <a href="mailto:{ContactEmail}">{ContactEmail}</a></p>
			<hr />
		</td>
	</tr>
</table>