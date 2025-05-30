@php
    



use Carbon\Carbon;
use Carbon\CarbonInterface;

if (!function_exists('hours_left')) {
    /**
     * Calculates the hours left from a given timestamp until now.
     *
     * @param  string  $timestamp The timestamp string (e.g., '2025-04-22 11:30:07').
     * @return string  The formatted string representing the hours left (e.g., '2 hours left').
     */
    function hours_left(string $timestamp): string
    {
        // 1. Create a Carbon instance from the timestamp string.
        $targetTime = Carbon::parse($timestamp);

        // 2. Get the current time as a Carbon instance.
        $now = Carbon::now();

        // 3. Calculate the difference in hours between the target time and now.
      // 3. Calculate the difference using Carbon's diffForHumans().
    //   $difference = $targetTime->diffForHumans($now);
      $difference= $now->diffForHumans($targetTime,[
    'syntax' => CarbonInterface::DIFF_ABSOLUTE,
]);
    //   $difference = $targetTime->diffForHumans($now);

// 4. Return the human-readable difference.

return $difference;
    }
}



@endphp


@extends('layouts.app')


@section('content')


<main
class="w-full px-6 pb-6  xl:px-12 xl:pb-12"
>
<div class="rounded-sm p-5 w-full m-10  bg-white dark:bg-darkblack-600 flex flex-col gap-2">

<div class="  flex flex-col    "  >
<div class="flex justify-center items-center overflow-hidden" style="height: 709px">
<img src="storage/uploads/{{$blog->image}}"  class="w-full" style=""/>
</div>
<div class=" flex-col justify-between gap-4 hidden" id="updateImage" >
        <form method="POST" action="{{route('update-blog')}}" enctype="multipart/form-data" >
            @csrf    

            <input type="text" name="id" value="{{$blog->id}}" class="hidden">
    <label
      for="fname"
      class="mb-2.5 w-full block text-left text-sm text-bgray-500 dark:text-bgray-50 mt-2">Update Image</label>
    <input type="file" name="image" class="w-full rounded-lg border border-bgray-300 px-4 py-3 focus:border focus:border-success-300 focus:ring-0 dark:border-darkblack-400 dark:bg-darkblack-600 text-bgray-500 dark:text-bgray-50 ">

</div>

</div>

<h1 class="item-text  font-bold dark:text-white " style="font-size: 40px" id="oldTitle">{{$blog->title}}</h1>
<input

name="title"
  type="text"
  class="h-10 w-full rounded-lg border border-bgray-300 px-4 py-3 focus:border focus:border-success-300 focus:ring-0 dark:border-darkblack-400 dark:bg-darkblack-600 text-bgray-500 dark:text-bgray-50 hidden"
value="{{$blog->title}}" id="updateTitle"
  />




<h3 class="dark:text-white text-black item-text" id="oldContent"> {!!$blog->content!!} </h3>




<div id="updateContent" class="hidden">
  
  <textarea
  name="content"
    class="h-36 w-full resize-none rounded-lg border border-bgray-300 px-4 py-3 focus:border focus:border-success-300 focus:ring-0 dark:border-darkblack-400 dark:bg-darkblack-600 text-bgray-500 
    dark:text-bgray-50 text-bgray-500 dark:text-bgray-50 hidden-area hidden"
  >{{{$blog->content}}}
  </textarea>
 
  <div id="quillEditor" >{!!$blog->content!!}</div>
</div>



<hr>

<div class="flex  justify-start items-center gap-4 dark:text-white">
   

    <p class="p-3 border border-solid  border-green-400 w-fit rounded-lg" id="oldCategory">{{$blog->category}}</p>
  
    @php
        
    $categories=['Entertainment',
'Nature',
'Gaming',
'Business',
'Science',
'Education',
'Sport',
'Travel'];


@endphp

    <select name="category" class=" p-3 border border-solid  border-green-400 w-fit rounded-lg focus:border focus:border-success-300 focus:ring-0 dark:border-darkblack-400 dark:bg-darkblack-600 text-bgray-500 dark:text-bgray-50 hidden" id="updateCategory">
       
        @foreach ($categories as $category )

        @if($blog->category==$category)
        <option selected>{{$category}} </option>
        
        @else
        <option >{{$category}} </option>
  @endif
  
        @endforeach 


        
    </select>

    <button type="submit" id="update" class=" rounded-lg bg-success-300 p-2 text-base font-medium text-white hover:bg-success-400  hidden" >Update</button>

</form>
    <div class="flex items-center justify-center gap-2">
    <p class=" block text-sm text-bgray-500 dark:text-bgray-50">Author</p>

  <small> {{$blog->author}} </small>
</div>
   
</div>
    @php
        
        $categories=['Entertainment',
    'Nature',
    'Gaming',
    'Business',
    'Science',
    'Education',
    'Sport',
    'Travel'];


    @endphp

    {{-- <select name="category"  class=" w-full rounded-lg border border-bgray-300 px-4 py-3 focus:border focus:border-success-300 focus:ring-0 dark:border-darkblack-400 dark:bg-darkblack-600 text-bgray-500 dark:text-bgray-50 ">
      
          


     
      



      
  </select> --}}

  
   
 {{-- solve preoblem --}}



  <div class="post-coment-area flex flex-col p-5 dark:text-white" >
    <h4 class="coments-area-title font-bold text-2xl " >
        
        @if(count($comments)<2)
        {{count($comments)}} Comment
        
        @else
        {{count($comments)}} Comments

    @endif
    </h4>
   
    <div class="flex flex-col "  >
        @foreach ($comments as $comment )
        <div class="flex flex-col">
        @if($comment->parent_id==null)
        
    <div class="post-comment-item flex flex-col gap-2" style="margin-top: 20px">
        <div class="flex flex-row gap-3">
        <div class="post-comment-author" style="">
            <img src="/assets/images/avatar/aj.png" alt="" class="post-author-image" /></div>
        <div class="post-comment-description flex flex-col">
            <div class="upper-description flex text-xl">
                <h5 class="comment-author-name font-bold ">{{$comment->user_name}}</h5>
                <div class="post-author-time text-sm    ">-   {{hours_left($comment->updated_at)}} ago</div>
            </div> 
            <div class="flex justify-start  ">
            <p class="post-comment-paragraph w-full ">{{$comment->body}}</p>
            <div class="flex flex-row gap-2 justify-center items-center text-sm ml-4">
            <span  class="post-reply w-button p-3 border border-solid hover:text-green-400 rounded-lg cursor-pointer " style="" onclick="commentToggle({{$comment->id}})" >reply</span>
               
                <form class="" method="POST"  action="{{route('delete-comment')}}" onsubmit="return toogleDelete()"> 
@csrf
                    <input type="text" name="id" value="{{$comment->id}}" class="hidden" >
            <button class=" text-red-600 hover:text-red-900  cursor-pointer  " type="submit"> Delete </button>
        </form>
            </div>
        </div> 
    </div>

</div>
 




    
    <hr class="mt-1">

   
    <div class="post-comment-item flex flex-col gap-2 w-full " style="margin-left: 45px; margin-top:10px; ">
        
   @foreach ($nested as $nested_comment)
 
@if($nested_comment->parent_id==$comment->id)
{{-- c --}}
   <div class="flex comment gap-4">
   <div class="post-comment-author" style=""><img src="/assets/images/avatar/aj.png" alt="" class="post-author-image" /></div>
   <div class="post-comment-description flex flex-col ml">
       <div class="upper-description flex text-xl">
           <h5 class="comment-author-name ">{{$nested_comment->user_name}}</h5>
           <div class="post-author-time text-sm">-   {{hours_left($nested_comment->updated_at)}}  ago</div>
       </div>
       <div class="flex justify-start ">
       <p class="post-comment-paragraph w-full">{{$nested_comment->body}}</p>
       <div class="flex flex-row gap-2 justify-center items-center text-sm ml-4">

       
       <form class="" method="POST"  action="{{route('delete-comment')}}" onsubmit="return toogleDelete()"> 
        @csrf
                            <input type="text" name="id" value="{{$nested_comment->id}}" class="hidden" >
                    <button class=" text-red-600 hover:text-red-900  cursor-pointer  " type="submit"> Delete </button>
                </form>
    </div>
   </div> 
</div>

</div>


{{-- c --}}





@endif

  
  
@endforeach
    @else
    
   
   
   @endif
   <form method="POST" action="{{route('admin-comment')}}" class="  flex-col   items-end mt-5 hidden" style="width: 720px" id="{{$comment->id}}" >
       @csrf
       <input type="text" name="post_id" class="hidden" value="{{$blog->id}}"/>
       <input type="text" name="parent_id" class="hidden" value="{{$comment->id}}"/>
       
       <textarea name="comment" id="Message" placeholder="reply" class="input-style input-style-single textarea w-full  rounded-md"></textarea>
       
       <input type="submit" name="submit" value="Submit" class="rounded-lg bg-success-300 px-6 py-3 text-base font-medium text-white hover:bg-success-400 mt-5" />
    </form>
    
</div> 

</div>
    @endforeach
    
   



<form method="POST" action="{{route('admin-comment')}}" class="w-full flex-col   items-end mt-5 " id="post-comment" >
    @csrf
    <input type="text" name="post_id" class="hidden" value="{{$blog->id}}"/>

    <textarea name="comment"  id="Message" placeholder="comment" class="input-style input-style-single textarea w-full  rounded-md"></textarea>

    <input type="submit" name="submit" value="Comment" class="rounded-lg bg-success-300 px-6 py-3 text-base font-medium text-white hover:bg-success-400 mt-5" />
</form>



<div class="flex gap-2 items-center " >

<button class=" mt-5" style="font-size: small" onclick="toggleInput()">Update Blog</button>


<form action="{{route('delete-post')}}" method="POST" onsubmit="return toogleDelete()">

    @csrf

    <input type="text" name="id" value="{{$blog->id}}" class="hidden" >
<button href="" class=" mt-5 text-red-800" style="font-size: small" type="submit" >Delete Blog</button>

</form>

</div>
</div>




</main>




<script>


function commentToggle(id)
{




commentForm=document.getElementById(id);


if (commentForm.style.display==="flex")
{

    commentForm.style.display="none";
}
else
{
    commentForm.style.display="flex";


}








}
// toggle update interface

function toggleInput()
{


    var updateTitle=document.getElementById('updateTitle');
    var updateCategory=document.getElementById('updateCategory');
    var updateContent=document.getElementById('updateContent');
    var updateBtn=document.getElementById('update');

    var updateImage=document.getElementById('updateImage');
    var quillEditor=document.getElementById('quillEditor');
    var oldCategory=document.getElementById('oldCategory');
    var oldContent=document.getElementById('oldContent');
    var oldTitle=document.getElementById('oldTitle');
   
    




    if(updateTitle.style.display==="flex")
{

   

    updateTitle.style.display="none";

   
    updateCategory.style.display="none";

    updateImage.style.display="none";
   updateContent.style.display="none";
   
    updateBtn.style.display="none";

     oldContent.style.display="flex";
      oldTitle.style.display="flex";
      oldContent.style.display="flex";
      oldCategory.style.display="flex";


}

else{

    
    updateTitle.style.display="flex";
    updateCategory.style.display="flex";

    updateImage.style.display="flex";
    updateContent.style.display="block";
    updateBtn.style.display="block";

    oldContent.style.display="none";
      oldTitle.style.display="none";
      oldContent.style.display="none";
      oldCategory.style.display="none";



}


}


</script>

<script>

    function toogleDelete()
    {

        const confirmation = confirm("Are you sure you want to delete?");

        if(confirmation)
    {


        return true;
    }

    else{
        return false;
    }


    }

    </script>


@endsection