<table>
    <thead>
    <tr>
        <td>handleId</td>
        <td>fieldType</td>
        <td>name</td>
        <td>description</td>
        <td>productImageUrl</td>
        <td>collection</td>
        <td>sku</td>
        <td>ribbon</td>
        <td>price</td>
        <td>surcharge</td>
        <td>visible</td>
        <td>discountMode</td>
        <td>discountValue</td>
        <td>inventory</td>
        <td>weight</td>
        <td>cost</td>
        <td>productOptionName1</td>
        <td>productOptionType1</td>
        <td>productOptionDescription1</td>
        <td>productOptionName2</td>
        <td>productOptionType2</td>
        <td>productOptionDescription2</td>
        <td>productOptionName3</td>
        <td>productOptionType3</td>
        <td>productOptionDescription3</td>
        <td>productOptionName4</td>
        <td>productOptionType4</td>
        <td>productOptionDescription4</td>
        <td>productOptionName5</td>
        <td>productOptionType5</td>
        <td>productOptionDescription5</td>
        <td>productOptionName6</td>
        <td>productOptionType6</td>
        <td>productOptionDescription6</td>
        <td>additionalInfoTitle1</td>
        <td>additionalInfoDescription1</td>
        <td>additionalInfoTitle2</td>
        <td>additionalInfoDescription2</td>
        <td>additionalInfoTitle3</td>
        <td>additionalInfoDescription3</td>
        <td>additionalInfoTitle4</td>
        <td>additionalInfoDescription4</td>
        <td>additionalInfoTitle5</td>
        <td>additionalInfoDescription5</td>
        <td>additionalInfoTitle6</td>
        <td>additionalInfoDescription6</td>
        <td>customTextField1</td>
        <td>customTextCharLimit1</td>
        <td>customTextMandatory1</td>
        <td>customTextField2</td>
        <td>customTextCharLimit2</td>
        <td>customTextMandatory2</td>
        <td>brand</td>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        @php
        try {
            $categories = $product->categories->pluck('name')->toArray();
            $name = str_replace("PIEZA BY BAUM SAC", "Pieza Baum", $product->store->name);
            $categories[] = $name;

            $description = \Illuminate\Support\Arr::get($product->properties, 'wix.description', $product->description);
            if (empty($description)) {
                if (\Illuminate\Support\Arr::get($product->properties, 'dimensions.width', 0) > 1) {
                    $description .= '<p>Ancho: '.(\Illuminate\Support\Arr::get($product->properties, 'dimensions.width', 0) / 10).'&nbsp;cm</p>';
                }
                if (\Illuminate\Support\Arr::get($product->properties, 'dimensions.height', 0) > 1) {
                    $description .= '<p>Alto: '.(\Illuminate\Support\Arr::get($product->properties, 'dimensions.height', 0) / 10).'&nbsp;cm</p>';
                }
                if (\Illuminate\Support\Arr::get($product->properties, 'dimensions.depth', 0) > 1) {
                    $description .= '<p>Profundidad: '.(\Illuminate\Support\Arr::get($product->properties, 'dimensions.depth', 0) / 10).'&nbsp;cm</p>';
                }

                $description = '<p>&nbsp;</p><p><strong>Marca: <a href="https://www.atelier-app.com/category/' . \Illuminate\Support\Str::slug($name) . '" target="_blank">' . $product->store->name . '</a></strong></p><p>&nbsp;</p><p><span style="color:#4fa277;">Diseña tu habitación con este y más productos directamente en nuestra App.</span><strong> <a href="https://apps.apple.com/us/app/atelier/id1565516356" target="_blank"><span style="color:#29705a;">Descarga&nbsp;Atelier App&nbsp;Aquí</span></a></strong></p>';
            }
        @endphp
        <tr>
            <td>{{ \Illuminate\Support\Arr::get($product->properties, 'wix.handleId', 'Product_' . $product->id) }}</td>
            <td>{{ \Illuminate\Support\Arr::get($product->properties, 'wix.fieldType', 'Product') }}</td>
            <td>{{ $product->title }}</td>
            <td>"{{ str_replace('"', '""', $description) }}"</td>
            <td>{{ \Illuminate\Support\Arr::get($product->properties, 'wix.productImageUrl') }}</td>
            <td>{{ \Illuminate\Support\Arr::get($product->properties, 'wix.collection', implode(";", $categories)) }}</td>
            <td>{{ $product->id }}</td>
            <td></td>
            <td>{{ $product->price }}</td>
            <td></td>
            <td>{{ \Illuminate\Support\Arr::get($product->properties, 'wix.visible', "false") }}</td>
            <td>PERCENT</td>
            <td>0</td>
            <td>{{ \Illuminate\Support\Arr::get($product->properties, 'wix.inventory', "InStock") }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $product->store->name }}</td>
        </tr>
        @php
        } catch (Exception $e) {
            dd(__METHOD__ . ': ' . __LINE__, $product->toArray());
        }
        @endphp
    @endforeach
    </tbody>
</table>
