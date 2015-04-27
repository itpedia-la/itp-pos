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
	 // window.close();
    </script>
  </head>
  
  <body>
    <div align="center" style="font-size:13px">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ<br>LAO PEOPLE'S DEMOCRATIC REPUBLIC<br/>ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນາຖາວອນ<br/>PEACE INDEPENDENCE DEMOCRACY UNITY PROSPERITY</div>
    <div class="container">
      <div class="row">
        <div class="col-xs-6">
          <h1>
             <img src="{{ URL::to('img/logo_print.png') }}">
          </h1>
        </div>
        <div class="col-xs-6 text-right">
      
        	<h1>ໃບສະເຫນີລາຄາ (Quotation)</h1>

          <h1><small>ເລກທີ: {{ $transaction_parent->transaction_number }}</small></h1>
           <p>ວັນທີ: {{ Tool::toDate($transaction_parent->created_at) }} | ໝົດກຳໜົດວັນທີ: {{ Tool::toDate($transaction_parent->quotation_expired_at) }}</p>
           <p>ໂດຍ: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} ({{ date('d-m-Y H:i') }})</p>
        </div>
      </div>
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
              <h4>ເຖິງ : {{ $transaction_parent->company_name }}</h4>
            </div>
            <div class="panel-body" style="padding: 10px">
              <p>
              	 @if ($transaction_parent->company_name) {{ $transaction_parent->company_name }} <br>@endif
              	  @if ($transaction_parent->contact_name) {{ $transaction_parent->contact_name }} <br>@endif
              	   @if ($transaction_parent->contact_telephone) {{ $transaction_parent->contact_telephone }} <br>@endif
                @if ($customer->email) {{ $customer->address }} <br>@endif
                @if ($customer->telephone) Tel: {{ @$customer->telephone }} <br>@endif
                 @if ($customer->fax) Fax: {{ @$customer->fax }} <br>@endif
                 @if ($customer->mobile) Mobile: {{ @$customer->mobile }} <br>@endif
                @if ($customer->email){{ @$customer->email }}@endif
                    ສະຖານທີ່ສົ່ງ: {{ $transaction_parent->send_location }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- / end client details section -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>
              <h4>ອັນດັບ</h4>
            </th>
            <th>
              <h4>ລາຍການ</h4>
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
        @foreach( $tranChild as $value )
          <tr>
             <td>{{ $value['index'] }}</td>
            <td>{{ $value['title'] }}</td>
            <td class="text-right">{{ $value['quality'] }}</td>
            <td class="text-right">{{ $value['price'] }}</td>
            <td class="text-right">{{ $value['total'] }}</td>
          </tr>
		@endforeach
			<tr>
             <td>&nbsp;</td>
            <td align="right"></td>
            <td align="right"></td>
            <td class="text-right"><b>ລວມ: {{ $sumM3 }}</b> m<sup>3</sup></td>
            <td class="text-right">&nbsp;</td>
            <td class="text-right">&nbsp;</td>
          </tr>
        </tbody>
      </table>
      <div class="row text-right">
        <div class="col-xs-2 col-xs-offset-8" style="line-height:2em">
          <p>
            <strong>
 
            ຍອດລວມທັງໝົດ : <br>
            </strong>
          </p>
        </div>
        <div class="col-xs-2" style="line-height:2em">
          <strong>

           {{ number_format($transaction_parent->grand_total,2) }} THB <br>
          </strong>
        </div>
      </div>
     <div class="row">
     	<div class="col-xs-8">
         
            <div class="panel-heading">
              <p><u>ຜູ້ອຳນວຍການ ບໍລິສັດ 1 ພຶດສະພາກຣຸບ ຈຳກັດຜູ້ດຽວ</u></p>
            </div>
            <div class="panel-body">
             
            </div>
     
        </div>

      </div>
    </div>
  </body>
</html>
