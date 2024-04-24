import FrontendLayout from "@/Layouts/Frontend/Layout";
import { Head } from "@inertiajs/react";

export default function TakeExam({ auth, status }) {
  return (
    <FrontendLayout user={auth.user}>
      <Head title="Exam Result" />

      <div className="grid gap-0 lg:grid-cols-1 lg:gap-8 mb-3 select-none">
        <div className="flex flex-col items-center gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
          <div className="w-full">
            <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
              {status}
            </h2>
          </div>
        </div>
      </div>
    </FrontendLayout>
  );
}
