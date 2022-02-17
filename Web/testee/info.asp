<!--
'********************************************************************************************
Versão: 1.1
Data Alteração: 
Data Alteração: 19/08/2008 (Dayvison Pellegrina)
Data Criação: 05/08/2008 (Dayvison Pellegrina)
'********************************************************************************************
-->
<%
'Configurações de Cache
Response.CacheControl = "Public" 
Response.Expires = 60



'Funções **********************************************************************************

function ordena(arrayTemp)
   for i = 0 to UBound(arrayTemp)
       for j = i+1 to UBound(arrayTemp)
           if (arrayTemp(i) > arrayTemp(j)) then
               'call swap(i, j) 'Passa o ponteiro para a funcao swap
							 valor_1_antigo = arrayTemp(i)
   						 valor_2_antigo = arrayTemp(j)
						   arrayTemp(i) = valor_2_antigo
						   arrayTemp(j) = valor_1_antigo 						 
           end if 
       next
   next
	 ordena = arrayTemp
end function


function ImprimirComponente(StrComponente)				 
				 strRetorno = ""
				 srtVersao = ""				 
				 on error resume next 
				 set obj = Server.CreateObject(StrComponente)
				 if err.number = 0 then				 
  
				 		strRetorno = "<tr> <td> " & Componente & "  </td> <td>Instalado"
				 		 
				 		srtVersao = obj.version
						
						if srtVersao <> "" then
						   strRetorno = strRetorno & " / Versão = " &  srtVersao
						end if
						 
						strRetorno = strRetorno & " </td> </tr>"
						 
						 
				 end if
				 ImprimirComponente = strRetorno
end function

'********************************************************************************************


'Escrever componentes separados por "|" 
strComponentes = "AspHTTP.Conn|InternetExplorer.Application|ABCpdf3.Doc|ABCpdf4.Doc|ABCpdf5.Doc|MSWC.AdRotator|Persits.Upload.1|Persits.Upload|Persits.MailSender|Persits.Grid|Persits.Jpeg|Persits.Pdf|obout_aspTreeview_Pro.tree|obout_asptreeview_XP.tree|obout_ASPTreeview_2.Tree|CDO.Message|ChartDirector.API|csImageFile.Manage|Dundas.PieChartServer.2|Dynu.DNS|Dynu.Encrypt|Dynu.HTTP|Dynu.POP3|Softartisans.ExcelWriter|SoftArtisans.ImageGen|OWC10.ChartSpace|SoftArtisans.FileUp|SoftArtisans.SMTPMail|SoftArtisans.Archive|Dundas.Upload.2|AspSmartUpLoad.SmartUpLoad|CDONTS.NewMail|POP3svg.Mailer|SMTPsvg.Mailer|Scripting.FileSystemObject|ADODB.Connection|ADODB.RecordSet"


%>
<Html>
<Body>

<center>
<font face="arial" >

<h1>Listagem de Componentes</h1>

<table align="center" border="1" style="color:Black;background-color:White;border-color:#CCCCCC;border-style:None;width:708px;border-collapse:collapse;font-family:verdana;font-size:12">
<tr style="color:White;background-color:#333333;font-weight:bold;">
<td>Componente</td>
<td>Status</td>
</tr>
<%
arrComponentes = split(strComponentes,"|")
arrComponentes = ordena(arrComponentes)
for each Componente in arrComponentes

		Response.Write(ImprimirComponente(Componente))

next
%>
</table>
<h5>Obs: <a href="http://site.locaweb.com.br/suporte/Faq/faq.asp?CodigoCategoria=4770">Clique aqui</a> para saber os componentes que disponibilizamos.
</h5>

<br />
<br />
<h1>Variáveis do Servidor</h1>
<table  align="center" border="1" style="color:Black;background-color:White;border-color:#CCCCCC;border-style:None;width:708px;border-collapse:collapse;font-family:verdana;font-size:12">
<tr style="color:White;background-color:#333333;font-weight:bold;">
<td>Variável</td>
<td>Valor</td>
</tr>
<%

For Each Item In Request.ServerVariables

		Response.Write("<tr>")
		Response.Write("<td>")		
		Response.Write(Item)
		Response.Write("</td>")
		Response.Write("<td>")		
		Response.Write(Request.ServerVariables(Item))
		Response.Write("</td>")		
		Response.Write("</tr>")	
Next

%>
</table>





<br />
<br />
<h1>Dados do Servidor</h1>
<table  align="center" border="1" style="color:Black;background-color:White;border-color:#CCCCCC;border-style:None;width:708px;border-collapse:collapse;font-family:verdana;font-size:12">
<tr style="color:White;background-color:#333333;font-weight:bold;">
<td>Informação</td>
<td>Valor</td>
</tr>


<tr><td>Hora</td><td><%=time()%></td></tr>
<tr><td>Data</td><td><%=date()%></td></tr>
<tr><td>Script Timeout</td><td><%=Server.ScriptTimeout%></td></tr>
<tr><td>Session Timeout</td><td><%=Session.Timeout%></td></tr>
<tr><td>LCID</td><td><%=Session.Lcid()%></td></tr>
<tr><td>Buffer</td><td><%=Response.Buffer%></td></tr>



</table>






</font>
</center>
</Body>
</Html>