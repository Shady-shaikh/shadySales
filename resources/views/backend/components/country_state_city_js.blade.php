<script type="text/javascript">
    function get_states(country,state=null){
    if(country){
        $.ajax({
            type:'POST',
            headers: { // Set headers object
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
            },
            url:"{{route('admin.country_state_city')}}",
            data:'country_id='+country,
            success:function(data){
                data = JSON.parse(data.states);
                var html = '<option value="">Select state</option>';
                $.each(data, function(key,val){
                    if(state == key){
                        html += '<option value='+key+' selected>'+val+'</option>';
                    }else{
                        html += '<option value='+key+'>'+val+'</option>';
                    }
                });
                $('#state').html(html);
                $('#city').html('<option value="">Select state first</option>'); 
            }
        }); 
    }else{
        $('#state').html('<option value="">Select country first</option>');
        $('#city').html('<option value="">Select state first</option>'); 
    }
}

function get_cities(state,city=null){
    if(state){
        $.ajax({
            type:'POST',
            headers: { // Set headers object
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
            },
            url:"{{route('admin.country_state_city')}}",
            data:'state_id='+state,
            success:function(data){
                data = JSON.parse(data.cities);
                var html = '<option value="">Select city</option>';
                $.each(data, function(key,val){
                    if(city == key){
                        html += '<option value='+key+' selected>'+val+'</option>';
                    }else{
                        html += '<option value='+key+'>'+val+'</option>';
                    }
                });
                $('#city').html(html);
            }
        }); 
    }else{
        $('#city').html('<option value="">Select state first</option>'); 
    }
}
    $(document).ready(function(){
        var state = "{{isset($data)?$data->state:''}}";
        var city = "{{isset($data)?$data->city:''}}";
        if(state){
            get_states($('#country').val(),state);
            setTimeout(() => {
                get_cities(state,city);
            }, 500);
        }
           
     

        $('#country').on('change',function(){
            get_states($(this).val());
        });
        
        $('#state').on('change',function(){
            get_cities($(this).val());
        });
    });
</script>