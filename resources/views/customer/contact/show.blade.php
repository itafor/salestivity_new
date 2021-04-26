<div class="col-8">
    <h2 class="mb-0">{{ __('Contacts') }}</h2>
</div>
                    
<div class="table-responsive">
    <table class="table align-items-center table-flush">
        <thead>
            <tr>
                <th scope="col">{{ __('S/N') }}</th>
                <th scope="col">{{ __('Title') }}</th>
                <th scope="col">{{ __('Surname') }}</th>
                <th scope="col">{{ __('Other Names') }}</th>
                <th scope="col">{{ __('Phone') }}</th>
                <th scope="col">{{ __('Email') }}</th>
                <th scope="col">{{ __('Delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($contacts->count() >=1)
            @foreach($contacts as $contact)
             @if($customer->email != $contact->email && $contact->title !=null )
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$contact->title}}</td>
                    <td>{{$contact->surname}}</td>
                    <td>{{$contact->name}}</td>
                    <td>{{$contact->phone}}</td>
                    <td>{{$contact->email}}</td>
                    <td>
                        <a onclick="deleteData('contact','destroy',{{$contact->id}})">
                            <button class="btn btn-sm btn-danger"><i class="las la-trash-alt"></i></button>
                        </a>
                    </td>
              </tr>   
              @endif              
                @endforeach      
            @else
            <tr>
                <td colspan="8">
                <h5>No Contact record found</h5> 
                </td>
            </tr>
            @endif
        </tbody>
    </table>    
</div>
