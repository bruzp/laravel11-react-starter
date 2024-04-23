import AuthenticatedLayout from "@/Layouts/User/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Dashboard({ auth, rank }) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          My Dashboard
        </h2>
      }
    >
      <Head title="Dashboard" />

      <div className="py-12">
        <div className="max-w-full mx-auto sm:px-6 lg:px-8">
          <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              You are currently ranked {rank.rank_text} overall, with an average
              result of {rank.max_result}%.
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
