<x-app-layout>
    <header class="mb-6">
        <span class="text-base font-bold font-inter">Request ID & Title: {{ $ticket?->requester_id }} , {{ $ticket?->title }}</span>
    </header>

    <div class="flex flex-wrap" id="tabs-id">
    <div class="w-full">
    <ul class="flex mb-0 list-none bg-[#F3F4F6]">
    <li class="-mb-px last:mr-0 px-5 text-center">
        <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-primary-400 text-white" onclick="changeAtiveTab(event,'tab-detail')">
        <i class="fas fa-space-shuttle text-base mr-1"></i>  Details
        </a>
    </li>
    <li class="-mb-px last:mr-0 px-5 text-center">
        <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-transparent text-black-400" onclick="changeAtiveTab(event,'tab-conversation')">
        <i class="fas fa-cog text-base mr-1"></i>  Conversations
        </a>
    </li>
    <li class="-mb-px last:mr-0 px-5 text-center">
        <a class="cursor-pointer text-sm font-semibold font-inter py-3 px-5 block bg-transparent text-black-400" onclick="changeAtiveTab(event,'tab-history')">
        <i class="fas fa-briefcase text-base mr-1"></i>  History
        </a>
    </li>
    </ul>

        <div class="relative flex flex-col min-w-0 break-words bg-white w-full my-6">
        <div class="px-4 py-5 flex-auto">
            <div class="tab-content tab-space">
            <div class="block" id="tab-detail">
                Hello
            </div>
            <div class="hidden" id="tab-conversation">
                Conversations Content is here..
            </div>
            <div class="hidden" id="tab-history">
                History Content is here..
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
    function changeAtiveTab(event, tabID) {
        let element = event.target;
        while (element.nodeName !== "A") {
        element = element.parentNode;
        }
        ulElement = element.parentNode.parentNode;
        aElements = ulElement.querySelectorAll("li > a");
        tabContents = document.getElementById("tabs-id").querySelectorAll(".tab-content > div");
        
        // Loop through all tabs and reset them to inactive styles
        for (let i = 0; i < aElements.length; i++) {
        aElements[i].classList.remove("text-white");
        aElements[i].classList.remove("bg-primary-400");
        aElements[i].classList.add("text-black-400");
        aElements[i].classList.add("bg-transparent");
        tabContents[i].classList.add("hidden");
        tabContents[i].classList.remove("block");
        }
        
        // Apply active styles to the clicked tab
        element.classList.remove("text-black-400");
        element.classList.remove("bg-transparent");
        element.classList.add("text-white");
        element.classList.add("bg-primary-400");
        
        // Show the corresponding content
        document.getElementById(tabID).classList.remove("hidden");
        document.getElementById(tabID).classList.add("block");
    }
    </script>


</x-app-layout>