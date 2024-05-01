import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { format } from "date-fns";

export default function Dashboard({ auth, top10_users }) {
  return (
    <AuthenticatedLayout
      admin={auth.admin}
      header={
        <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          Top 10 All Time Highest Examinee Ratings
        </h2>
      }
    >
      <Head title="Admin Dashboard" />

      <div className="py-12">
        <div className="max-w-full mx-auto sm:px-6 lg:px-8">
          <div className="bg-dark dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              <div className="space-y-4">
                {top10_users.map((user) => (
                  <div
                    className="card bg-dark shadow-md rounded p-4"
                    key={user.id}
                  >
                    <h2 className="font-bold text-lg">{user.name}</h2>
                    <p>{user.result}%</p>
                    <p className="text-sm text-gray-500">
                      {format(user.created_at, "yyyy-mm-dd")}
                    </p>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
