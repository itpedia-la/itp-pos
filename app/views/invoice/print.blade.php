<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.css') }}">
    <style>
      /*@import url(http://fonts.googleapis.com/css?family=Bree+Serif);
      body, h1, h2, h3, h4, h5, h6{
      font-family: 'Bree Serif', serif;
      }*/
    </style>
    <script type="text/javascript">
	
	 window.print();
	  //window.close();
    </script>
  </head>
  
  <body>
  <div align="center" style="font-size:13px">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ<br>LAO PEOPLE'S DEMOCRATIC REPUBLIC<br/>ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ<br/>PEACE INDEPENDENCE DEMOCRACY UNITY PROSPERITY</div>
    <div class="container">
      <!--<div class="row">
         <div class="col-xs-6">
          <h1>
           
            <img src="{{ URL::to('img/logo_print.png') }}">
          
          </h1>
        </div>
        <div class="col-xs-6 text-right">

        	<h1>{{ TransactionInvoice::title(Route::input('invoice_id'))['la'] }} - {{ TransactionInvoice::title(Route::input('invoice_id'))['en'] }}</h1>

          	<h1><small>ລະຫັດ: {{ @$invoice_number }}</small></h1>
     		<h1><small>ວັນທີ ອອກໃບຮຽກເກັບເງິນ: {{ Tool::toDate(@$invoice->invoice_issue_date) }}<br/>@if(TransactionInvoice::title(Route::input('invoice_id'))['type'] == 0) ກຳໜົດຊຳລະພາຍໃນວັນທີ: {{ Tool::toDate($invoice->invoice_due_date) }} @else ວັນທີຊຳລະເງິນ: {{ Tool::toDate($invoice->invoice_clear_date) }} @endif</small></h1>
           <p>ໂດຍ: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} ({{ date('d-m-Y H:i') }})</p>
        </div> 
      </div>-->
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
      	<tr>
      		<td width="25%"><img src="{{ URL::to('img/logo.png') }}" width="100"></td>
      		<td align="center" width="50%"><h1>{{ TransactionInvoice::title(Route::input('invoice_id'))['la'] }}<br/><span style="margin-top:5px; font-size:22px">{{ TransactionInvoice::title(Route::input('invoice_id'))['en'] }}</span></h1></td>
      		<td align="right" width="25%"><img src="{{ URL::to('img/logo_tpipl.png') }}"></td>
      	</tr>
      	<tr>
      		<td><h4>ລະຫັດ: {{ @$invoice_number }}</h4></td>
      		<td align="center"></td>
      		<td align="right"><h4>ວັນທີ: {{ Tool::toDate(@$invoice->invoice_issue_date) }}</h4></td>
      	</tr>
      	<tr>
      		<td colspan="2"><h4>ໂດຍ: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} ({{ date('d-m-Y H:i') }})</h4></td>
      		
      		<td align="right"><h4>@if(TransactionInvoice::title(Route::input('invoice_id'))['type'] == 0) ກຳໜົດຊຳລະ: {{ Tool::toDate($invoice->invoice_due_date) }} @else ວັນທີຊຳລະເງິນ: {{ Tool::toDate($invoice->invoice_clear_date) }} @endif</h4></td>
      	</tr>
      
      </table>
     
      <div class="row">
        <div class="col-xs-5">
          <div class="panel panel-default">
            <div class="panel-heading" style="padding: 0px 10px 0px 10px">
              <h4>ຈາກ: {{ @$company->company_name }}</h4>
            </div>
           <div class="panel-body" style="padding: 10px">
              <p>
                @if ($company->address){{ $company->address }} <br>@endif
               @if ($company->telephone)ໂທລະສັບ: {{ @$company->telephone }} <br>@endif
                @if ($company->fax)ແຟກ: {{ @$company->fax }} <br>@endif
                @if ($company->mobile)Hotline: {{ @$company->mobile }} <br>@endif
                @if ($company->email)Email: {{ @$company->email }} @endif
              </p>
            </div>
          </div>
        </div>
        <div class="col-xs-5 col-xs-offset-2 text-right">
          <div class="panel panel-default">
            <div class="panel-heading" style="padding: 0px 10px 0px 10px">
              <h4>ເຖິງ : {{ @$customer->company_name }}</h4>
            </div>
            <div class="panel-body" style="padding: 10px">
              <p>
              	 @if ($customer->company_name) {{ $customer->company_name }} <br>@endif
              	  @if ($customer->contact_name) {{ $customer->contact_name }} <br>@endif
              	   @if ($customer->contact_telephone) {{ $customer->contact_telephone }} <br>@endif
                @if ($customer->email) {{ $customer->address }} <br>@endif
                @if ($customer->telephone) Tel: {{ @$customer->telephone }} <br>@endif
                 @if ($customer->fax) Fax: {{ @$customer->fax }} <br>@endif
                 @if ($customer->mobile) Mobile: {{ @$customer->mobile }} <br>@endif
                @if ($customer->email){{ @$customer->email }}@endif
             
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- / end client details section -->
      <table class="table table-bordered" style="font-size:11px">
        <thead>
          <tr>
            <th>
              <h4>ລະຫັດ</h4>
            </th>
            <th>
              <h4>ໃບເບີກຈ່າຍ</h4>
            </th>
            <th>
              <h4>ລາຍການ</h4>
            </th>
            <th>
              <h4>ວັນທີ</h4>
            </th>
            <th>
              <h4>ຈຳນວນ</h4>
            </th>
            <th>
              <h4>ລາຄາ</h4>
            </th>
            <th>
              <h4>ລວມລາຄາ</h4>
            </th>
          </tr>
        </thead>
        <tbody>
        @foreach ( array_slice($data,1) as $value )
          <tr>
            <td><b>{{ $value['index'] }}.) {{ @$value['id'] }}</b></td>
            <td><b>{{ @$value['send_location'] }}</b></td>
            <td></td>
            <td class="text-right"></td>
            <td class="text-right"><b>{{ @$value['sum_m3_child'] }}</b></td>
            <td class="text-right"></td>
             <td class="text-right"><b>{{ @$value['grand_total_html'] }}</b></td>
          </tr>
          
          @if( @$value['transaction_childs'] )
          @foreach ( $value['transaction_childs'] as $child )
	          <tr>
	            <td align="right">{{ $child['index'] }}.</td>
	            <td>{{ $child['issue_slip_id'] }}</td>
	            <td>{{ $child['title'] }}</td>
	            <td>{{ $child['issue_date'] }}</td>
	            <td class="text-right">{{ $child['quality'] }}</td>
	            <td class="text-right">{{ $child['price'] }} THB</td>
	            <td class="text-right">{{ $child['total'] }} THB</td>
	          </tr>
          @endforeach
           <tr>
	            <td colspan="7">&nbsp;</td>
	        </tr>
	     
          @endif
		@endforeach
		@if($penalty)
		  @foreach( $penalty as $pen_row )
          <tr>
            <td align="right">1.</td>
            <td colspan="2">ຄ່າປັບໄໝ ໃບຮຽກເກັບເງິນ ເລກທີ: {{ $pen_row['invoice_number'] }}, ອອກວັນທີ: {{ $pen_row['invoice_issue_date'] }}</td>
            <td>ກຳໜົດຊຳລະ: {{ $pen_row['invoice_due_date'] }}</td>
            <td class="text-right">{{ $pen_row['percentage_of_penalty'] }}%</td>
            <td class="text-right">{{ $pen_row['amount_total'] }}</td>
            <td class="text-right">{{ $pen_row['amount_penalty'] }}</td>
          </tr>

	        @endforeach
	      @endif
	                   <tr>
	            <td colspan="7">&nbsp;</td>
	        </tr>
		<tr>
             <td>&nbsp;</td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td class="text-right"><b>ລວມ:</b> {{ $data[0]['sum_m3'] }}</td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right"><b>{{ $data[0]['sum_grand_total_all'] }}</b> THB </td>
          </tr>
        </tbody>
      </table>
      <div class="row text-right">
        <div class="col-xs-2 col-xs-offset-8" style="line-height:2em">
          <p>
            <strong style="font-size:13px">
 
            ຍອດລວມທັງໝົດ : <br>
            </strong>
          </p>
          <p>
            <strong style="font-size:13px">
 
            ຍອດເງິນ ທີ່ຊຳລະ : <br>
            </strong>
          </p>
          @if( TransactionInvoice::title(Route::input('invoice_id'))['type'] == 0 )
          <p>
            <strong style="font-size:13px">
 
            ຍອດເງິນ ທີ່ຕ້ອງຊຳລະ : <br>
            </strong>
          </p>
          @endif
        </div>
        <div class="col-xs-2" style="line-height:2em; font-size:12px">
        <p>
          <strong>
           {{ $data[0]['sum_grand_total_all'] }} THB <br>
          </strong>
          </p>
          <p>
          <strong>
           ({{ number_format(TransactionPayment::getPaid(Route::input('invoice_id')),2) }} THB)<br>
          </strong>
          </p>
            @if( TransactionInvoice::title(Route::input('invoice_id'))['type'] == 0 )
          <p>
           <strong>
          {{ number_format(TransactionPayment::getRemain(Route::input('invoice_id')),2) }} THB <br>
          </strong>
          </p>
          @endif
          <p>

          </p>
        </div>
      </div>

      <div class="row">
     	<div class="col-xs-8">
         
            <div class="panel-heading">
              <p><u style="font-size:13px">ຜູ້ອຳນວຍການ ບໍລິສັດ 1 ພຶດສະພາກຣຸບ ຈຳກັດຜູ້ດຽວ</u></p>
            </div>
            <div class="panel-body">
             
            </div>
     
        </div>
        </div>
    </div>
  </body>
</html>
