<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('My Questions') }}
        </x-header>
    </x-slot>


    <x-container>

        <x-form post :action="route('question.store')">
            <x-textarea label="Question" name="question" />
            <x-btn.primary>Save</x-btn.primary>
            <x-btn.reset>Cancel</x-btn.reset>
        </x-form>

        {{--  Start - My Drafts --}}
        <hr class="border-gray-700 border-dashed my-4">

        <div class="dark:text-gray-400 font-bold uppercase mb-1">
            Drafts
        </div>

        <div class="dark:text-gray-400 space-y-4">
            <x-table>
            <x-table.thead>
                <tr>
                    <x-table.th>Question</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </tr>
            </x-table.thead>

                <tbody>
                @foreach($questions->where('draft', true ) as $question)
                    <x-table.tr>
                        <x-table.td  width="80%">{{$question->question}}</x-table.td>
                        <x-table.td>
                            <div class="flex justify-start space-x-3">
                            <x-form :action="route('question.destroy', $question)" delete>
                                <button type="submit" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-1 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Delete</button>
                            </x-form>
                                <x-form :action="route('question.destroy', $question)" delete>
                                    <button type="submit" class="text-yellow-700 hover:text-white border border-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-2 py-1 text-center me-2 mb-2 dark:border-yellow-500 dark:text-yellow-500 dark:hover:text-white dark:hover:bg-yellow-600 dark:focus:ring-yellow-900">Edit</button>
                                </x-form>
                            <x-form :action="route('question.publish', $question)" put>
                                <button type="submit" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-1 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-500 dark:focus:ring-green-800">Publish</button>
                            </x-form>
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>
        {{--  End - My Question --}}
        {{--  Start - My Question --}}
        <hr class="border-gray-700 border-dashed my-4">

        <div class="dark:text-gray-400 font-bold uppercase mb-1">
            My Questions
        </div>

        <div class="dark:text-gray-400 space-y-4">
            <x-table>
            <x-table.thead>
                <tr>
                    <x-table.th>Question</x-table.th>
                    <x-table.th>Actions</x-table.th>
                </tr>
            </x-table.thead>

                <tbody>
                @foreach($questions->where('draft', false ) as $question)
                    <x-table.tr>
                        <x-table.td width="80%">{{$question->question}}</x-table.td>
                        <x-table.td>
                            <div class="flex justify-start space-x-3">
                            <x-form :action="route('question.destroy', $question)" delete>
                                <button type="submit" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-1 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Delete</button>
                            </x-form>
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>
        {{--  End - My Question --}}
    </x-container>
</x-app-layout>
