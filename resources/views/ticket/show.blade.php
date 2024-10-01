<x-app-layout>
    <div class="grid sm:grid-cols-1 md:grid-cols-2 md:gap-1 sm:gap-1">
        <div class="border border-slate-300 px-5 py-10 rounded">
            <div class="grid md:grid-cols-1 sm:grid-cols-1 border border-slate-300 px-10 py-3 rounded">
                <div class="grid sm:grid-cols-2 md:grid-cols-2 md:gap-1 sm:gap-1">
                    <div class="left">
                        <div class="flex">
                            <div class="pr-3">
                                <img src="https://i.pravatar.cc/300/10" alt="img" height="50" width="50" style="border-radius: 50%">
                            </div>

                            <div class="content">
                                <h3 class="font-inter font-bold text-sm">Albert Adrose</h3>
                                <ul>
                                    <li>
                                        <p class="font-inter font-semibold text-sm inline-block">Requester ID: </p>
                                        <span class="text-sm font-inter font-thin"> #12546856</span>
                                    </li>
                                    <li>
                                        <p class="font-inter font-semibold text-sm inline-block">Phone: </p>
                                        <span class="text-sm font-inter font-thin"> 0179567896</span>
                                    </li>
                                    <li>
                                        <p class="font-inter font-semibold text-sm inline-block">Email: </p>
                                        <span class="text-sm font-inter font-thin"> thealamdev@gmail.com</span>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>

                    <div class="right">
                        <p class="font-ineter font-semibold text-sm inline-block">Title : </p> <span class="font-inter font-thin text-sm"> Delays or errors in processing financial aid applications, grants, or scholarships</span>
                    </div>
                </div>

                <div class="mt-3 bg-[#F8F8F8] px-8 py-5 rounded text-justify">
                    <p class="font-ineter font-semibold text-sm inline-block">Request Description:</p> <span class="font-inter font-thin text-sm">Request Description: This issue pertains to problems students encounter when applying for or receiving financial aid, grants, or scholarships from their educational institution. Delays or errors in the processing of these applications can cause significant stress and hardship for students.</span>
                </div>
            </div>

            <div class="grid md:grid-cols-1 sm:grid-cols-1 border border-slate-300 px-10 py-3 rounded mt-5">
                <div class="flex justify-between items-center flex-wrap">
                    <div>
                        <p class="font-ineter font-thin text-sm">Attached File</p>
                        <x-forms.input-file />
                    </div>
                    <div>
                        <p class="font-ineter font-thin text-sm">Priority</p>
                        <span class="font-ineter font-semibold text-sm">High</span>
                    </div>
                    <div>
                        <p class="font-ineter font-thin text-sm">Due Date</p>
                        <span class="font-ineter font-semibold text-sm">17 Aug, 2017</span>
                    </div>
                    <div>
                        <p class="font-ineter font-thin text-sm">Soure</p>
                        <span class="font-ineter font-semibold text-sm">Website</span>
                    </div>
                </div>
                <div class="flex justify-between items-center flex-wrap mt-3">
                    <div>
                        <p class="font-ineter font-thin text-sm">Category</p>
                        <span class="font-ineter font-semibold text-sm">Financial</span>
                    </div>
                    <div>
                        <p class="font-ineter font-thin text-sm">Assign Team</p>
                        <span class="font-ineter font-semibold text-sm">Finance</span>
                    </div>
                    <div>
                        <p class="font-ineter font-thin text-sm">Requester Type</p>
                        <span class="font-ineter font-semibold text-sm">Student</span>
                    </div>
                    <div>
                        <p class="font-ineter font-thin text-sm">Assign Agent</p>
                        <span class="font-ineter font-semibold text-sm">Finance</span>
                    </div>
                </div>
                <div class="flex justify-between items-center flex-wrap mt-3">
                    <div>
                        <p class="font-ineter font-thin text-sm">Status</p>
                        <span class="font-ineter font-semibold text-sm">Open</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
