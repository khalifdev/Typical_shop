<h3>Заказ #{{ID}}</h3>
<div>Статус заказа: <span data-id="{{ID}}">{{STATUS}}</span></div>
<table class="cartTable">
	<thead>
	<tr>
		<td>Название</td>
		<td>Стоимость</td>
		<td>Количество</td>
		<td>Сумма</td>
	</tr>
	</thead>
	<tbody>
	{{CONTENT}}
	<tr>
		<td colspan="3">Итого</td>
		<td>{{SUM}}</td>
	</tr>
	</tbody>
</table>

