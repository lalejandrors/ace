<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Ace Software Médico</title>
	</head>
	<body style="margin:0;padding:0;">
		<table width="100%" align="center" bgcolor="#959595" cellpadding="0" cellspacing="0" style="text-align:center;font-family:Arial, Helvetica, sans-serif;color:#000000; font-size:12px;">
			<tbody>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" width="600" bgcolor="#FFFFFF" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:15px;">
							<tr>
								<td bgcolor="#4FA9DD" height="75" align="center" style="color:#FFFFFF; text-align:center;"></td>
							</tr>
							<tr>
								<td height="5" bgcolor="#1998df"></td>
							</tr>
							<tr>
								<td><img style="margin: 30px;" src="{{ asset('logo/'.$logo) }}" style="display:block;" border="0" width="540" height="auto"/></td>
							</tr>
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" width="600">
										<tr>
											<td width="25"></td>
											<td width="550">
												
											<p>Hola {{ $nombrePaciente }}, esta es la información de tu cita médica:</p>
											<p><b>Tipo de Cita: </b>{{ $tipoCita }}.</p>
											<p><b>Fecha y Hora: </b>{{ $fechaHoraCita }}.</p>
											<br>
											<p>Gracias por hacer parte de {{ $razonSocial }}, te esperamos.</p>

											</td>
											<td width="25"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="30"></td>
							</tr>
						</table>
						<table cellpadding="0" cellspacing="0" width="600" bgcolor="#eaeaea" align="center" style="font-family:Arial, Helvetica, sans-serif;">
							<tr>
								<td height="10"></td>
							</tr>
							<tr>
								<td height="80" align="center" style="text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#878787;"><b>Mantente siempre en contacto con {{ $razonSocial }}!</b></td>
							</tr>
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" width="600" bgcolor="#eaeaea" align="center" style="font-family:Arial, Helvetica, sans-serif;">
										<tr>
											<td width="145"></td>
											<td width="310" height="42" align="center" style="text-align:center; border-bottom:3px solid #25aa7e;font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#878787;">
												{{ $direccion }}<br />
												{{ $telefonos }}<br />
												{{ $email }}<br />
												@if($infoAdicional != '')
													<br />{{ $infoAdicional }}<br /><br /><br />
												@endif
											</td>
											<td width="145"></td>
										</tr>
										@if($linkWeb != '')
											<tr>
												<td width="145"></td>
												<td width="310" height="42" bgcolor="#33cc99" align="center" style="background-color:#33cc99; text-align:center; border-bottom:3px solid #25aa7e;">
													<a href="{{ $linkWeb }}" target="_blank" style="font-size:19px; color:#fff; text-decoration: none;">VISITA NUESTRO SITIO</a>
												</td>
												<td width="145"></td>
											</tr>
										@endif
									</table>
								</td>
							</tr>
							<tr>
								<td height="50">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" width="600" bgcolor="#676767" align="center">
							<tr>
								<td height="80" width="30"></td>
								<td height="80" width="465" align="left" style="font-family:Arial, Helvetica, sans-serif; color:#FFFFFF; font-size:10px; text-align:left;">
									<br />
									<strong style="font-size:14px;">{{ 'Dr(a). '.$nombreMedico }}</strong><br />
									{{ $especialidadMedico }}<br />
									{{ $correoMedico }}<br /><br />
									Powered by Ace Software M&eacute;dico.
									<br /><br />
								</td>
								@if($linkFacebook != '')
									<td width="30"><a href="{{ $linkFacebook }}" target="_blank" style="border:none;"><img src="{{ asset('images/fb.png') }}" border="0" /></a></td>
									<td width="15"></td>
								@endif
								@if($linkTwitter != '')
									<td width="30"><a href="{{ $linkTwitter }}" target="_blank" style="border:none;"><img src="{{ asset('images/tw.png') }}" border="0" /></a></td>
									<td width="15"></td>
								@endif
								@if($linkYoutube != '')
									<td width="30"><a href="{{ $linkYoutube }}" target="_blank" style="border:none;"><img src="{{ asset('images/yt.png') }}" border="0" /></a></td>
									<td width="15"></td>
								@endif
								@if($linkInstagram != '')
									<td width="30"><a href="{{ $linkInstagram }}" target="_blank" style="border:none;"><img src="{{ asset('images/ig.png') }}" border="0" /></a></td>
									<td width="15"></td>
								@endif
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>